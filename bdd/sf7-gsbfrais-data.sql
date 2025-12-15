INSERT INTO Etat (id, libelle) VALUES
('CL', 'Saisie clôturée'),
('CR', 'Fiche créée, saisie en cours'),
('RB', 'Remboursée'),
('VA', 'Validée et mise en paiement');
INSERT INTO FraisForfait (id, libelle, montant) VALUES
('ETP', 'Forfait Etape', '110.00'),
('KM', 'Frais Kilométrique', '0.62'),
('NUI', 'Nuitée Hôtel', '80.00'),
('REP', 'Repas Restaurant', '25.00');
INSERT INTO Visiteur (id, nom, prenom, login, mdp, adresse, cp, ville, dateEmbauche) VALUES
('a17', 'Andre', 'David', 'dandre', 'oppg5', '1 rue Petit', '46200', 'Lalbenque', '1998-11-23'),
('a55', 'Bedos', 'Christian', 'cbedos', 'passe', '1 rue Peranud', '46250', 'Montcuq', '1995-01-12');
INSERT INTO FicheFrais (`id`, `visiteur_id`, `mois`, `nbJustificatifs`, `montantValide`, `dateModif`, `etat_id`) VALUES
(1, 'a17', '201706', 8, 2356.18, '2017-08-02', 'RB'),
(2, 'a17', '201707', 7, 1558.66, '2017-08-02', 'VA'),
(3, 'a17', '201708', 11, 0.00, '2017-08-02', 'CR'),
(4, 'a55', '201703', 2, 1931.23, '2017-05-05', 'RB'),
(5, 'a55', '201704', 2, 4719.92, '2017-06-01', 'RB'),
(6, 'a55', '201705', 6, 3741.58, '2017-07-06', 'RB'),
(7, 'a55', '201706', 11, 3716.14, '2017-08-07', 'RB'),
(8, 'a55', '201707', 6, 3355.24, '2017-08-03', 'VA'),
(9, 'a55', '201708', 6, 0.00, '2017-08-08', 'CR');