--
-- Ajout de de la table `puissanceVehicule`
--

CREATE TABLE IF NOT EXISTS `puissanceVehicule` (
  `id` int(11) NOT NULL auto_increment,
  `puissance` varchar(50) NOT NULL,
  `tarif` decimal(10,2) NOT NULL,
  `moisFicheFrais` char(6) NOT NULL,
  --FOREIGN KEY (`moisFicheFrais`) REFERENCES fichefrais(`mois`),
  PRIMARY KEY (id)
) ENGINE=InnoDB;

-- ----------------------------------------------------------

--
-- Ajout de de la table `Vehicule`
--

CREATE TABLE IF NOT EXISTS `vehicule` (
  `id` int(11) NOT NULL auto_increment,
  `libelle` varchar(50) NOT NULL,
  `immatriculation` varchar(50) NOT NULL,
  `idPuissanceVehicule` int(11) NOT NULL,
  `idActeur` char(4),
  PRIMARY KEY (id),
  FOREIGN KEY (`idPuissanceVehicule`) REFERENCES puissanceVehicule(`id`),
  FOREIGN KEY (`idActeur`) REFERENCES acteur(`id`)
) ENGINE=InnoDB;



ALTER TABLE `puissanceVehicule`
ADD FOREIGN KEY (`moisFicheFrais`) REFERENCES fichefrais(`mois`);