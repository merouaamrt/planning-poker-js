/**
 * Crée un joueur
 * @param {string} pseudo
 * @returns {object} Joueur avec pseudo et vote
 */
export function createPlayer(pseudo) {
  if (!pseudo || pseudo.trim() === '') throw new Error("Pseudo invalide");
  return { pseudo, vote: null };
}

/**
 * Définit le nombre de joueurs
 * @param {Array} players
 * @param {number} n
 * @returns {Array} Liste mise à jour
 */
export function defineNumberOfPlayers(players, n) {
  while (players.length < n) players.push({ pseudo: "", vote: null });
  return players.slice(0, n);
}

/**
 * Ajoute un vote pour un joueur
 * @param {object} player
 * @param {number|string} vote
 * @returns {object} Joueur avec vote mis à jour
 */
export function castVote(player, vote) {
  if (vote === null || vote === undefined) throw new Error("Vote invalide");
  return { ...player, vote };
}

/**
 * Calcule estimation selon règle
 * @param {Array<object>} players
 * @param {string} rule - "moyenne" | "mediane" | "stricte"
 * @returns {number|null} Estimation
 */
export function calculateEstimate(players, rule = "moyenne") {
  const votes = players.map(p => p.vote).filter(v => typeof v === "number");
  if (!votes.length) return null;

  if (rule === "moyenne") return votes.reduce((a,b)=>a+b,0)/votes.length;

  if (rule === "mediane") {
    votes.sort((a,b)=>a-b);
    const mid = Math.floor(votes.length/2);
    return votes.length % 2 === 0 ? (votes[mid-1]+votes[mid])/2 : votes[mid];
  }

  if (rule === "stricte") return votes.every(v=>v===votes[0]) ? votes[0] : null;
}
