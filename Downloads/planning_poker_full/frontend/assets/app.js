document.addEventListener('DOMContentLoaded', ()=>{
  if (document.getElementById('createBtn')) {
    document.getElementById('createBtn').onclick = async () => {
      const pseudo = document.getElementById('pseudo').value || 'Host';
      let backlog;
      try { backlog = JSON.parse(document.getElementById('backlog').value); } catch(e){ alert('Backlog JSON invalide'); return; }
      const mode = document.getElementById('mode').value;
      const body = { backlog, mode, scrumMaster: pseudo };
      const res = await fetch('/api/session/create', {
        method: 'POST',
        headers: {'Content-Type':'application/json'},
        body: JSON.stringify(body)
      }).then(r=>r.json());
      if (res.status === 'created') {
        localStorage.setItem('lastPartie', JSON.stringify(res.partie));
        window.location = '/frontend/room.html';
      } else {
        alert('Erreur: ' + JSON.stringify(res));
      }
    };
    document.getElementById('openBtn').onclick = () => { window.location = '/frontend/room.html'; };
  }

  if (document.getElementById('joinBtn')) {
    document.getElementById('joinBtn').onclick = async () => {
      const pseudo = document.getElementById('pseudoJoin').value || 'Guest';
      const saved = JSON.parse(localStorage.getItem('lastPartie') || 'null');
      if (!saved) return alert('Aucune partie locale trouvée. Crée une partie d\'abord');
      const partieFile = saved ? ('data/partie_' + saved.idPartie + '.json') : null;
      const res = await fetch('/api/session/join', {
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body: JSON.stringify({ partieFile, pseudo })
      }).then(r=>r.json());
      if (res.status === 'joined') {
        localStorage.setItem('lastPartie', JSON.stringify(res.partie));
        refreshRoom();
      } else {
        alert('Erreur join: ' + JSON.stringify(res));
      }
    };
  }

  if (document.getElementById('refreshBtn')) {
    document.getElementById('refreshBtn').onclick = refreshRoom;
  }

  renderCards();
  refreshRoom();
});

function renderCards() {
  const cardsContainer = document.getElementById('cards');
  if (!cardsContainer) return;
  const values = [1,2,3,5,8,13,'cafe'];
  cardsContainer.innerHTML = '';
  values.forEach(v=>{
    const el = document.createElement('div');
    el.className = 'card-vote p-2 text-center';
    el.innerHTML = '<div>'+v+'</div>';
    el.onclick = () => submitVote(v);
    cardsContainer.appendChild(el);
  });
}

async function refreshRoom() {
  const partieData = JSON.parse(localStorage.getItem('lastPartie') || 'null');
  if (!partieData) {
    document.getElementById('playersList').innerHTML = '<li class="list-group-item">Aucune partie chargée</li>';
    document.getElementById('currentFeature').innerText = 'Aucune';
    document.getElementById('partieJson').innerText = 'Aucune';
    return;
  }
  const res = await fetch('/api/partie/current').then(r=>r.json());
  if (res.error) {
    document.getElementById('playersList').innerHTML = '<li class="list-group-item">Aucune partie serveur</li>';
    return;
  }
  const partie = res.partie;
  document.getElementById('playersList').innerHTML = '';
  partie.listeJoueurs.forEach(j=>{
    const li = document.createElement('li'); li.className='list-group-item'; li.innerText = j.pseudo;
    document.getElementById('playersList').appendChild(li);
  });
  const story = partie.backlog.fonctionnalites[partie.currentIndex] || null;
  document.getElementById('currentFeature').innerText = story ? (story.titre + ' - ' + (story.description || '')) : 'Aucune';
  document.getElementById('partieJson').innerText = JSON.stringify(partie, null, 2);
}

async function submitVote(value) {
  const partieData = JSON.parse(localStorage.getItem('lastPartie') || 'null');
  if (!partieData) return alert('Aucune partie locale');
  const partieFile = 'data/partie_' + partieData.idPartie + '.json';
  const playerId = 1;
  const res = await fetch('/api/vote/submit', {
    method:'POST',
    headers:{'Content-Type':'application/json'},
    body: JSON.stringify({ partieFile, playerId, value })
  }).then(r=>r.json());
  if (res.error) return alert('Erreur vote: ' + JSON.stringify(res));
  alert('Vote envoyé. Status: ' + res.status);
  refreshRoom();
}
