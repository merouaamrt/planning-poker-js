import { createPlayer, defineNumberOfPlayers, castVote, calculateEstimate } from './planningPoker.js';

describe("Gestion des joueurs", () => {
  test("Créer un joueur valide", () => {
    const p = createPlayer("Alice");
    expect(p.pseudo).toBe("Alice");
    expect(p.vote).toBeNull();
  });

  test("Créer un joueur invalide", () => {
    expect(() => createPlayer("")).toThrow("Pseudo invalide");
  });

  test("Définir nombre de joueurs", () => {
    const players = [{pseudo:"Alice", vote:null}];
    const updated = defineNumberOfPlayers(players, 3);
    expect(updated.length).toBe(3);
  });
});

describe("Système de vote", () => {
  test("Un joueur peut voter", () => {
    const player = createPlayer("Bob");
    const voted = castVote(player, 5);
    expect(voted.vote).toBe(5);
  });

  test("Calcul moyenne", () => {
    const players = [
      castVote(createPlayer("Alice"), 3),
      castVote(createPlayer("Bob"), 5)
    ];
    expect(calculateEstimate(players, "moyenne")).toBe(4);
  });

  test("Calcul médiane", () => {
    const players = [
      castVote(createPlayer("Alice"), 3),
      castVote(createPlayer("Bob"), 5),
      castVote(createPlayer("Charlie"), 8)
    ];
    expect(calculateEstimate(players, "mediane")).toBe(5);
  });

  test("Règle stricte", () => {
    const players = [
      castVote(createPlayer("Alice"), 5),
      castVote(createPlayer("Bob"), 5)
    ];
    expect(calculateEstimate(players, "stricte")).toBe(5);

    const players2 = [
      castVote(createPlayer("Alice"), 3),
      castVote(createPlayer("Bob"), 5)
    ];
    expect(calculateEstimate(players2, "stricte")).toBeNull();
  });
});
