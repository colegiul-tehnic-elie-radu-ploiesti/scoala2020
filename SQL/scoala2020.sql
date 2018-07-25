-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2018 at 03:28 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scoala2020`
--

-- --------------------------------------------------------

--
-- Table structure for table `absente`
--

CREATE TABLE `absente` (
  `id_absenta` int(11) NOT NULL,
  `id_an_scolar` int(11) NOT NULL,
  `id_materie` int(11) NOT NULL,
  `id_clasa` int(11) NOT NULL,
  `semestru` int(11) NOT NULL,
  `id_elev` int(11) NOT NULL,
  `data_absenta` text NOT NULL,
  `comentarii` text NOT NULL,
  `motivata` int(11) NOT NULL DEFAULT '0',
  `comentarii_motivare` text NOT NULL,
  `data_motivare` text NOT NULL,
  `data_adaugare` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `absente`
--

INSERT INTO `absente` (`id_absenta`, `id_an_scolar`, `id_materie`, `id_clasa`, `semestru`, `id_elev`, `data_absenta`, `comentarii`, `motivata`, `comentarii_motivare`, `data_motivare`, `data_adaugare`) VALUES
(1, 1, 3, 1, 1, 1, '12/12/2017', 'A plecat de la ora', 0, '', '', 1520714758),
(2, 1, 1, 1, 1, 1, '17/12/2017', 'A chiulit de ziua lui', 1, 'Scutire medicala nr 17/2018', '15/03/2018', 1521127584),
(3, 1, 1, 1, 1, 1, '12/12/2017', 'Plecat la dansuri', 0, '', '', 1521127584);

-- --------------------------------------------------------

--
-- Table structure for table `ani_scolari`
--

CREATE TABLE `ani_scolari` (
  `id_an_scolar` int(11) NOT NULL,
  `denumire_an_scolar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ani_scolari`
--

INSERT INTO `ani_scolari` (`id_an_scolar`, `denumire_an_scolar`) VALUES
(1, '2017-2018'),
(2, '2018-2019');

-- --------------------------------------------------------

--
-- Table structure for table `clase`
--

CREATE TABLE `clase` (
  `id_clasa` int(11) NOT NULL,
  `nivel_clasa` int(11) NOT NULL,
  `sufix_clasa` text NOT NULL,
  `id_diriginte` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clase`
--

INSERT INTO `clase` (`id_clasa`, `nivel_clasa`, `sufix_clasa`, `id_diriginte`) VALUES
(1, 11, 'A', 3),
(2, 11, 'B', 2);

-- --------------------------------------------------------

--
-- Table structure for table `elevi`
--

CREATE TABLE `elevi` (
  `id_elev` int(11) NOT NULL,
  `id_clasa` int(11) NOT NULL,
  `nume_elev` text NOT NULL,
  `nr_matricol` text NOT NULL,
  `adresa` text NOT NULL,
  `telefon` text NOT NULL,
  `email` text NOT NULL,
  `id_parinte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `elevi`
--

INSERT INTO `elevi` (`id_elev`, `id_clasa`, `nume_elev`, `nr_matricol`, `adresa`, `telefon`, `email`, `id_parinte`) VALUES
(1, 1, 'Ditu Andrei', '76', 'str Democratiei nr 78', '0762334445', 'superdenis99@yahoo.ro', 4),
(2, 1, 'Antonoiu Vasilica', '779', 'str Independentei nr 119B', '0777998990', 'vasilica@scoala2020.ro', 6);

-- --------------------------------------------------------

--
-- Table structure for table `forum_mesaje`
--

CREATE TABLE `forum_mesaje` (
  `id_mesaj` bigint(20) NOT NULL,
  `id_subiect` bigint(20) NOT NULL,
  `mesaj` text NOT NULL,
  `id_autor` int(11) NOT NULL,
  `data_adaugare` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `forum_mesaje`
--

INSERT INTO `forum_mesaje` (`id_mesaj`, `id_subiect`, `mesaj`, `id_autor`, `data_adaugare`) VALUES
(1, 2, 'Va rog sa aduceti cate 10 lei pentru fondul clasei.\r\nMultumesc.', 3, 1521131290),
(2, 5, 'Dorim sa stim cand va fi urmatoarea sedinta cu parintii. ', 6, 1521145707),
(3, 5, 'Putem organiza si o sedinta virtuala/videoconferinta?', 4, 1521145900),
(4, 5, 'Vom face urmatoarea sedinta cu parintii pe data de 1 iunie 2018. Va astept!', 3, 1521145958);

-- --------------------------------------------------------

--
-- Table structure for table `forum_subiecte`
--

CREATE TABLE `forum_subiecte` (
  `id_subiect` bigint(20) NOT NULL,
  `id_clasa` int(11) NOT NULL,
  `denumire_subiect` text NOT NULL,
  `initiator` text NOT NULL,
  `data_adaugare` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `forum_subiecte`
--

INSERT INTO `forum_subiecte` (`id_subiect`, `id_clasa`, `denumire_subiect`, `initiator`, `data_adaugare`) VALUES
(1, 1, 'Locatie banchet final an', '3', '1521129608'),
(2, 1, 'Fondul clasei', '3', '1521130135'),
(3, 1, 'Program Scoala Altfel', '3', '1521130152'),
(4, 1, 'Ghid BAC', '3', '1521130215'),
(5, 1, 'Sedinte cu parintii', '4', '1521145584');

-- --------------------------------------------------------

--
-- Table structure for table `materii`
--

CREATE TABLE `materii` (
  `id_materie` int(11) NOT NULL,
  `denumire_materie` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `materii`
--

INSERT INTO `materii` (`id_materie`, `denumire_materie`) VALUES
(1, 'Matematica'),
(2, 'Informatica'),
(3, 'Franceza'),
(4, 'Economie'),
(5, 'Engleza'),
(6, 'Istorie'),
(7, 'Geografie'),
(8, 'Educatie fizica'),
(9, 'Fizica'),
(10, 'Latina'),
(11, 'Religie'),
(12, 'Tehnologia Informatiei TIC'),
(13, 'Limba si literatura romana');

-- --------------------------------------------------------

--
-- Table structure for table `materii_clase`
--

CREATE TABLE `materii_clase` (
  `id_asociere` int(11) NOT NULL,
  `id_clasa` int(11) NOT NULL,
  `id_materie` int(11) NOT NULL,
  `id_an_scolar` int(11) NOT NULL,
  `are_teza` int(11) NOT NULL DEFAULT '0',
  `media` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `materii_clase`
--

INSERT INTO `materii_clase` (`id_asociere`, `id_clasa`, `id_materie`, `id_an_scolar`, `are_teza`, `media`) VALUES
(1, 1, 2, 1, 1, 0),
(3, 1, 1, 1, 1, 0),
(5, 1, 3, 1, 0, 0),
(7, 1, 4, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE `note` (
  `id_nota` bigint(20) NOT NULL,
  `id_elev` int(11) NOT NULL,
  `id_materie` int(11) NOT NULL,
  `id_profesor` int(11) NOT NULL,
  `nota` int(11) NOT NULL,
  `data_nota` text NOT NULL,
  `is_teza` int(11) NOT NULL COMMENT '0 - nu, 1 - da',
  `id_an_scolar` int(11) NOT NULL,
  `semestru` int(11) NOT NULL,
  `data_adaugare` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `note`
--

INSERT INTO `note` (`id_nota`, `id_elev`, `id_materie`, `id_profesor`, `nota`, `data_nota`, `is_teza`, `id_an_scolar`, `semestru`, `data_adaugare`) VALUES
(1, 1, 3, 3, 10, '15/03/2018', 0, 1, 1, 1521124477),
(2, 1, 3, 3, 8, '14/03/2018', 0, 1, 1, 1521126407),
(3, 1, 1, 3, 8, '21/10/2017', 0, 1, 1, 1521126439),
(4, 1, 1, 3, 9, '09/11/2017', 0, 1, 1, 1521126456),
(5, 1, 1, 3, 10, '05/12/2017', 0, 1, 1, 1521126470),
(6, 1, 1, 3, 8, '18/12/2017', 1, 1, 1, 1521126485),
(7, 1, 1, 3, 10, '14/03/2018', 0, 1, 2, 1521127794);

-- --------------------------------------------------------

--
-- Table structure for table `profesori`
--

CREATE TABLE `profesori` (
  `id_inregistrare` int(11) NOT NULL,
  `id_utilizator` int(11) NOT NULL,
  `materia_predata` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `setari`
--

CREATE TABLE `setari` (
  `setare` text NOT NULL,
  `valoare` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setari`
--

INSERT INTO `setari` (`setare`, `valoare`) VALUES
('an_scolar_curent', '1'),
('semestru_curent', '1');

-- --------------------------------------------------------

--
-- Table structure for table `utilizatori`
--

CREATE TABLE `utilizatori` (
  `id_utilizator` int(11) NOT NULL,
  `nume` text NOT NULL,
  `email` text NOT NULL,
  `parola` text NOT NULL,
  `tip_utilizator` int(11) NOT NULL COMMENT '1 - parinte, 2 - profesor, 3 - admin',
  `id_elev` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `utilizatori`
--

INSERT INTO `utilizatori` (`id_utilizator`, `nume`, `email`, `parola`, `tip_utilizator`, `id_elev`) VALUES
(1, 'Admin', 'admin@scoala2020.ro', '6226ff0e50b5313f287a6904ecf242b67d00d28bd211ddae51e8f044d24de0defd4daaa32eecac9bb13f9d2fe462941838937f16613aafdd075075ef9dfe7b64', 3, 0),
(2, 'Dumitrache Ion', 'vasile@scoala2020.ro', '431fb6702dab2ef5940dc1d1ae857aa014d0bb853159494d7f7cb14820893e12e40b6c23840c23c8040b3ec9366b9a8bd335aa661544463696630349bb283b35', 2, 0),
(3, 'Ionescu Test', 'ionescu@scoala2020.ro', '431fb6702dab2ef5940dc1d1ae857aa014d0bb853159494d7f7cb14820893e12e40b6c23840c23c8040b3ec9366b9a8bd335aa661544463696630349bb283b35', 2, 0),
(4, 'Matei Liana', 'parinte@scoala2020.ro', '431fb6702dab2ef5940dc1d1ae857aa014d0bb853159494d7f7cb14820893e12e40b6c23840c23c8040b3ec9366b9a8bd335aa661544463696630349bb283b35', 1, 1),
(6, 'Tanase Ion', 'tanase@scoala2020.ro', '431fb6702dab2ef5940dc1d1ae857aa014d0bb853159494d7f7cb14820893e12e40b6c23840c23c8040b3ec9366b9a8bd335aa661544463696630349bb283b35', 1, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absente`
--
ALTER TABLE `absente`
  ADD PRIMARY KEY (`id_absenta`);

--
-- Indexes for table `ani_scolari`
--
ALTER TABLE `ani_scolari`
  ADD PRIMARY KEY (`id_an_scolar`);

--
-- Indexes for table `clase`
--
ALTER TABLE `clase`
  ADD PRIMARY KEY (`id_clasa`);

--
-- Indexes for table `elevi`
--
ALTER TABLE `elevi`
  ADD PRIMARY KEY (`id_elev`);

--
-- Indexes for table `forum_mesaje`
--
ALTER TABLE `forum_mesaje`
  ADD PRIMARY KEY (`id_mesaj`);

--
-- Indexes for table `forum_subiecte`
--
ALTER TABLE `forum_subiecte`
  ADD PRIMARY KEY (`id_subiect`);

--
-- Indexes for table `materii`
--
ALTER TABLE `materii`
  ADD PRIMARY KEY (`id_materie`);

--
-- Indexes for table `materii_clase`
--
ALTER TABLE `materii_clase`
  ADD PRIMARY KEY (`id_asociere`);

--
-- Indexes for table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id_nota`);

--
-- Indexes for table `profesori`
--
ALTER TABLE `profesori`
  ADD PRIMARY KEY (`id_inregistrare`);

--
-- Indexes for table `utilizatori`
--
ALTER TABLE `utilizatori`
  ADD PRIMARY KEY (`id_utilizator`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absente`
--
ALTER TABLE `absente`
  MODIFY `id_absenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ani_scolari`
--
ALTER TABLE `ani_scolari`
  MODIFY `id_an_scolar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `clase`
--
ALTER TABLE `clase`
  MODIFY `id_clasa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `elevi`
--
ALTER TABLE `elevi`
  MODIFY `id_elev` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `forum_mesaje`
--
ALTER TABLE `forum_mesaje`
  MODIFY `id_mesaj` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `forum_subiecte`
--
ALTER TABLE `forum_subiecte`
  MODIFY `id_subiect` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `materii`
--
ALTER TABLE `materii`
  MODIFY `id_materie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `materii_clase`
--
ALTER TABLE `materii_clase`
  MODIFY `id_asociere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `note`
--
ALTER TABLE `note`
  MODIFY `id_nota` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `profesori`
--
ALTER TABLE `profesori`
  MODIFY `id_inregistrare` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `utilizatori`
--
ALTER TABLE `utilizatori`
  MODIFY `id_utilizator` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
