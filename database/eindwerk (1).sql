-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 14 jun 2013 om 19:54
-- Serverversie: 5.5.24-log
-- PHP-versie: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `eindwerk`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tbladmin`
--

CREATE TABLE IF NOT EXISTS `tbladmin` (
  `AdminID` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `AdminLogin` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `AdminPas` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`AdminID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Gegevens worden uitgevoerd voor tabel `tbladmin`
--

INSERT INTO `tbladmin` (`AdminID`, `AdminLogin`, `AdminPas`) VALUES
(1, 'admin', 'adminpas');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tblafbeeldingen`
--

CREATE TABLE IF NOT EXISTS `tblafbeeldingen` (
  `AfbeeldingID` bigint(15) unsigned NOT NULL AUTO_INCREMENT,
  `ProductID` int(10) unsigned NOT NULL,
  `AfbeeldingURL` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`AfbeeldingID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=28 ;

--
-- Gegevens worden uitgevoerd voor tabel `tblafbeeldingen`
--

INSERT INTO `tblafbeeldingen` (`AfbeeldingID`, `ProductID`, `AfbeeldingURL`) VALUES
(24, 82, '../../images/afbeeldingen/82_24.jpg'),
(23, 81, '../../images/afbeeldingen/81_23.jpg'),
(20, 80, '../../images/afbeeldingen/80_20.jpg'),
(22, 79, '../../images/afbeeldingen/79_22.jpg'),
(25, 83, '../../images/afbeeldingen/83_25.jpg'),
(27, 84, '../../images/afbeeldingen/84_27.jpg');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tblauteurs`
--

CREATE TABLE IF NOT EXISTS `tblauteurs` (
  `AuteursID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `AuteursNaam` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `AuteursOmschrijving` text COLLATE utf8_unicode_ci NOT NULL,
  `Status` tinyint(1) NOT NULL,
  PRIMARY KEY (`AuteursID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Gegevens worden uitgevoerd voor tabel `tblauteurs`
--

INSERT INTO `tblauteurs` (`AuteursID`, `AuteursNaam`, `AuteursOmschrijving`, `Status`) VALUES
(1, 'Pieter Aspe', 'Van bruggen', 1),
(2, 'Marc De bel', 'Jeugdboeken schrijver', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tblbestellingen`
--

CREATE TABLE IF NOT EXISTS `tblbestellingen` (
  `BestellingID` bigint(12) unsigned NOT NULL AUTO_INCREMENT,
  `KlantID` int(10) unsigned NOT NULL,
  `Status` tinyint(3) unsigned NOT NULL,
  `LeveringsmethodeID` tinyint(3) NOT NULL,
  `BetalingsmethodeID` tinyint(3) NOT NULL,
  `AdresIP` varchar(39) COLLATE utf8_unicode_ci NOT NULL,
  `BestellingTimestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `LeveringsStraat` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `LeveringsNr` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `LeveringsPostcode` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `LeveringsGemeente` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`BestellingID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=24 ;

--
-- Gegevens worden uitgevoerd voor tabel `tblbestellingen`
--

INSERT INTO `tblbestellingen` (`BestellingID`, `KlantID`, `Status`, `LeveringsmethodeID`, `BetalingsmethodeID`, `AdresIP`, `BestellingTimestamp`, `LeveringsStraat`, `LeveringsNr`, `LeveringsPostcode`, `LeveringsGemeente`) VALUES
(6, 5, 2, 2, 2, '128.102.102', '2013-06-13 10:53:16', 'Leuterweg', '31', '3630', 'Maasmechelen'),
(7, 0, 0, 0, 0, '', '2013-06-14 17:54:45', '', '', '', ''),
(8, 5, 1, 3, 4, 'localhost', '2013-06-14 18:43:38', 'Leuterweg', '31', '3630', 'Maasmechelen'),
(9, 5, 1, 3, 4, 'localhost', '2013-06-14 18:45:16', 'Leuterweg', '31', '3630', 'Maasmechelen'),
(10, 5, 1, 3, 4, 'localhost', '2013-06-14 18:54:39', 'Leuterweg', '31', '3630', 'Maasmechelen'),
(11, 5, 1, 3, 4, 'localhost', '2013-06-14 19:00:29', 'Leuterweg', '31', '3630', 'Maasmechelen'),
(12, 5, 1, 3, 4, 'localhost', '2013-06-14 19:02:44', 'Leuterweg', '31', '3630', 'Maasmechelen'),
(13, 5, 1, 3, 4, 'localhost', '2013-06-14 19:05:24', 'Leuterweg', '31', '3630', 'Maasmechelen'),
(14, 5, 1, 3, 4, 'localhost', '2013-06-14 19:13:08', 'Leuterweg', '31', '3630', 'Maasmechelen'),
(15, 5, 1, 3, 4, 'localhost', '2013-06-14 19:16:28', 'Leuterweg', '31', '3630', 'Maasmechelen'),
(16, 5, 1, 3, 4, 'localhost', '2013-06-14 19:18:00', 'Leuterweg', '31', '3630', 'Maasmechelen'),
(17, 5, 1, 3, 4, 'localhost', '2013-06-14 19:20:09', 'Leuterweg', '31', '3630', 'Maasmechelen'),
(18, 5, 1, 3, 4, 'localhost', '2013-06-14 19:21:00', 'Leuterweg', '31', '3630', 'Maasmechelen'),
(19, 5, 1, 3, 4, 'localhost', '2013-06-14 19:22:09', 'Leuterweg', '31', '3630', 'Maasmechelen'),
(20, 5, 1, 3, 4, 'localhost', '2013-06-14 19:24:11', 'Leuterweg', '31', '3630', 'Maasmechelen'),
(21, 5, 1, 3, 4, 'localhost', '2013-06-14 19:25:43', 'Leuterweg', '31', '3630', 'Maasmechelen'),
(22, 5, 1, 3, 4, 'localhost', '2013-06-14 19:29:42', 'Leuterweg', '31', '3630', 'Maasmechelen'),
(23, 5, 1, 3, 4, 'localhost', '2013-06-14 19:30:44', 'Leuterweg', '31', '3630', 'Maasmechelen');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tblbestellingendetail`
--

CREATE TABLE IF NOT EXISTS `tblbestellingendetail` (
  `BestellingDetailID` bigint(14) unsigned NOT NULL AUTO_INCREMENT,
  `BestellingID` bigint(12) NOT NULL,
  `ProductID` int(10) NOT NULL,
  `ProductAantal` tinyint(3) NOT NULL,
  `ProductPrijs` decimal(10,2) NOT NULL,
  PRIMARY KEY (`BestellingDetailID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Gegevens worden uitgevoerd voor tabel `tblbestellingendetail`
--

INSERT INTO `tblbestellingendetail` (`BestellingDetailID`, `BestellingID`, `ProductID`, `ProductAantal`, `ProductPrijs`) VALUES
(2, 6, 80, 10, '50.00'),
(3, 8, 79, 2, '50.00'),
(4, 9, 80, 1, '50.00'),
(5, 9, 79, 1, '50.00'),
(6, 10, 79, 1, '50.00'),
(7, 11, 79, 1, '50.00'),
(8, 12, 80, 1, '50.00'),
(9, 13, 79, 1, '50.00'),
(10, 14, 80, 1, '50.00'),
(11, 15, 79, 1, '50.00'),
(12, 16, 80, 1, '50.00'),
(13, 17, 80, 1, '50.00'),
(14, 18, 79, 1, '50.00'),
(15, 19, 80, 1, '50.00'),
(16, 20, 79, 1, '50.00'),
(17, 21, 79, 1, '50.00'),
(18, 22, 79, 1, '50.00'),
(19, 23, 80, 1, '50.00');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tblbetalingsmethodes`
--

CREATE TABLE IF NOT EXISTS `tblbetalingsmethodes` (
  `BetalingsmethodeID` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `BetalingsmethodeNaam` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `Kosten` decimal(4,2) NOT NULL,
  PRIMARY KEY (`BetalingsmethodeID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Gegevens worden uitgevoerd voor tabel `tblbetalingsmethodes`
--

INSERT INTO `tblbetalingsmethodes` (`BetalingsmethodeID`, `BetalingsmethodeNaam`, `Kosten`) VALUES
(4, 'Bancontact/Mister Cash/Maestro', '0.00'),
(5, 'Vooruitbetaling', '0.00'),
(7, 'Creditkaart', '0.20'),
(8, 'Direct banking', '0.00'),
(9, 'Paypall', '0.00'),
(10, 'Overschrijving', '0.00');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tblcategorie`
--

CREATE TABLE IF NOT EXISTS `tblcategorie` (
  `CategorieID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `Status` tinyint(1) unsigned NOT NULL,
  `CategorieNaam` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `CategorieOmschrijving` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`CategorieID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Gegevens worden uitgevoerd voor tabel `tblcategorie`
--

INSERT INTO `tblcategorie` (`CategorieID`, `Status`, `CategorieNaam`, `CategorieOmschrijving`) VALUES
(3, 0, 'Thriller', 'Dit is een thrillerzzz'),
(4, 1, 'Roman', 'Dit is een roman'),
(5, 1, 'Fictie', 'dit is een fictie'),
(6, 1, 'Jeugdboeken', 'Dit is een categorie voor de jeug');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tblklanten`
--

CREATE TABLE IF NOT EXISTS `tblklanten` (
  `KlantID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `LandID` tinyint(3) unsigned NOT NULL,
  `Email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Paswoord` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Voornaam` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Familienaam` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Straat` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `Nummer` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `Postcode` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `Gemeente` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `Telefoon` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `Bedrijf` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Organisatie` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `BTWNummer` bigint(12) NOT NULL,
  `Website` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `RegistratieTimestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`KlantID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Gegevens worden uitgevoerd voor tabel `tblklanten`
--

INSERT INTO `tblklanten` (`KlantID`, `LandID`, `Email`, `Paswoord`, `Voornaam`, `Familienaam`, `Straat`, `Nummer`, `Postcode`, `Gemeente`, `Telefoon`, `Bedrijf`, `Organisatie`, `BTWNummer`, `Website`, `RegistratieTimestamp`) VALUES
(5, 23, 'thomas.debois@gmail.com', 'swordspider00', 'Thomas', 'Debois', 'Leuterweg', '31', '3630', 'Maasmechelen', '0473789411', 'Student', 'HPO Kortrijk', 12345678912, 'www.thomas.be', '2013-06-13 10:48:00');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tbllanden`
--

CREATE TABLE IF NOT EXISTS `tbllanden` (
  `LandID` smallint(4) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `LandNaam` varchar(40) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden uitgevoerd voor tabel `tbllanden`
--

INSERT INTO `tbllanden` (`LandID`, `Status`, `LandNaam`) VALUES
(1, 0, 'Afghanistan'),
(2, 0, 'Albania'),
(3, 1, 'Algeria'),
(4, 1, 'American Samoa'),
(5, 1, 'Andorra'),
(6, 1, 'Angola'),
(7, 1, 'Anguilla'),
(8, 1, 'Antarctica'),
(9, 1, 'Antigua and Barbuda'),
(10, 1, 'Argentina'),
(11, 1, 'Armenia'),
(12, 1, 'Armenia'),
(13, 1, 'Aruba'),
(14, 1, 'Australia'),
(15, 1, 'Austria'),
(16, 1, 'Azerbaijan'),
(17, 1, 'Azerbaijan'),
(18, 1, 'Bahamas'),
(19, 1, 'Bahrain'),
(20, 1, 'Bangladesh'),
(21, 1, 'Barbados'),
(22, 1, 'Belarus'),
(23, 1, 'Belgium'),
(24, 1, 'Belize'),
(25, 1, 'Benin'),
(26, 1, 'Bermuda'),
(27, 1, 'Bhutan'),
(28, 1, 'Bolivia'),
(29, 1, 'Bosnia and Herzegovina'),
(30, 1, 'Botswana'),
(31, 1, 'Bouvet Island'),
(32, 1, 'Brazil'),
(33, 1, 'British Indian Ocean Territory'),
(34, 1, 'Brunei Darussalam'),
(35, 1, 'Bulgaria'),
(36, 1, 'Burkina Faso'),
(37, 1, 'Burundi'),
(38, 1, 'Cambodia'),
(39, 1, 'Cameroon'),
(40, 1, 'Canada'),
(41, 1, 'Cape Verde'),
(42, 1, 'Cayman Islands'),
(43, 1, 'Central African Republic'),
(44, 1, 'Chad'),
(45, 1, 'Chile'),
(46, 1, 'China'),
(47, 1, 'Christmas Island'),
(48, 1, 'Cocos (Keeling) Islands'),
(49, 1, 'Colombia'),
(50, 1, 'Comoros'),
(51, 1, 'Congo'),
(52, 1, 'Congo, The Democratic Republic of The'),
(53, 1, 'Cook Islands'),
(54, 1, 'Costa Rica'),
(55, 1, 'Cote D''ivoire'),
(56, 1, 'Croatia'),
(57, 1, 'Cuba'),
(58, 1, 'Cyprus'),
(60, 1, 'Czech Republic'),
(61, 1, 'Denmark'),
(62, 1, 'Djibouti'),
(63, 1, 'Dominica'),
(64, 1, 'Dominican Republic'),
(65, 1, 'Easter Island'),
(66, 1, 'Ecuador'),
(67, 1, 'Egypt'),
(68, 1, 'El Salvador'),
(69, 1, 'Equatorial Guinea'),
(70, 1, 'Eritrea'),
(71, 1, 'Estonia'),
(72, 1, 'Ethiopia'),
(73, 1, 'Falkland Islands (Malvinas)'),
(74, 1, 'Faroe Islands'),
(75, 1, 'Fiji'),
(76, 1, 'Finland'),
(77, 1, 'France'),
(78, 1, 'French Guiana'),
(79, 1, 'French Polynesia'),
(80, 1, 'French Southern Territories'),
(81, 1, 'Gabon'),
(82, 1, 'Gambia'),
(83, 1, 'Georgia'),
(85, 1, 'Germany'),
(86, 1, 'Ghana'),
(87, 1, 'Gibraltar'),
(88, 1, 'Greece'),
(89, 1, 'Greenland'),
(91, 1, 'Grenada'),
(92, 1, 'Guadeloupe'),
(93, 1, 'Guam'),
(94, 1, 'Guatemala'),
(95, 1, 'Guinea'),
(96, 1, 'Guinea-bissau'),
(97, 1, 'Guyana'),
(98, 1, 'Haiti'),
(99, 1, 'Heard Island and Mcdonald Islands'),
(100, 1, 'Honduras'),
(101, 1, 'Hong Kong'),
(102, 1, 'Hungary'),
(103, 1, 'Iceland'),
(104, 1, 'India'),
(105, 1, 'Indonesia'),
(106, 1, 'Indonesia'),
(107, 1, 'Iran'),
(108, 1, 'Iraq'),
(109, 1, 'Ireland'),
(110, 1, 'Israel'),
(111, 1, 'Italy'),
(112, 1, 'Jamaica'),
(113, 1, 'Japan'),
(114, 1, 'Jordan'),
(115, 1, 'Kazakhstan'),
(116, 1, 'Kazakhstan'),
(117, 1, 'Kenya'),
(118, 1, 'Kiribati'),
(119, 1, 'Korea, North'),
(120, 1, 'Korea, South'),
(121, 1, 'Kosovo'),
(122, 1, 'Kuwait'),
(123, 1, 'Kyrgyzstan'),
(124, 1, 'Laos'),
(125, 1, 'Latvia'),
(126, 1, 'Lebanon'),
(127, 1, 'Lesotho'),
(128, 1, 'Liberia'),
(129, 1, 'Libyan Arab Jamahiriya'),
(130, 1, 'Liechtenstein'),
(131, 1, 'Lithuania'),
(132, 1, 'Luxembourg'),
(133, 1, 'Macau'),
(134, 1, 'Macedonia'),
(135, 1, 'Madagascar'),
(136, 1, 'Malawi'),
(137, 1, 'Malaysia'),
(138, 1, 'Maldives'),
(139, 1, 'Mali'),
(140, 1, 'Malta'),
(141, 1, 'Marshall Islands'),
(142, 1, 'Martinique'),
(143, 1, 'Mauritania'),
(144, 1, 'Mauritius'),
(145, 1, 'Mayotte'),
(146, 1, 'Mexico'),
(147, 1, 'Micronesia, Federated States of'),
(148, 1, 'Moldova, Republic of'),
(149, 1, 'Monaco'),
(150, 1, 'Mongolia'),
(151, 1, 'Montenegro'),
(152, 1, 'Montserrat'),
(153, 1, 'Morocco'),
(154, 1, 'Mozambique'),
(155, 1, 'Myanmar'),
(156, 1, 'Namibia'),
(157, 1, 'Nauru'),
(158, 1, 'Nepal'),
(159, 1, 'Netherlands'),
(160, 1, 'Netherlands Antilles'),
(161, 1, 'New Caledonia'),
(162, 1, 'New Zealand'),
(163, 1, 'Nicaragua'),
(164, 1, 'Niger'),
(165, 1, 'Nigeria'),
(166, 1, 'Niue'),
(167, 1, 'Norfolk Island'),
(168, 1, 'Northern Mariana Islands'),
(169, 1, 'Norway'),
(170, 1, 'Oman'),
(171, 1, 'Pakistan'),
(172, 1, 'Palau'),
(173, 1, 'Palestinian Territory'),
(174, 1, 'Panama'),
(175, 1, 'Papua New Guinea'),
(176, 1, 'Paraguay'),
(177, 1, 'Peru'),
(178, 1, 'Philippines'),
(179, 1, 'Pitcairn'),
(180, 1, 'Poland'),
(181, 1, 'Portugal'),
(182, 1, 'Puerto Rico'),
(183, 1, 'Qatar'),
(184, 1, 'Reunion'),
(185, 1, 'Romania'),
(186, 1, 'Russia'),
(187, 1, 'Russia'),
(188, 1, 'Rwanda'),
(189, 1, 'Saint Helena'),
(190, 1, 'Saint Kitts and Nevis'),
(191, 1, 'Saint Lucia'),
(192, 1, 'Saint Pierre and Miquelon'),
(193, 1, 'Saint Vincent and The Grenadines'),
(194, 1, 'Samoa'),
(195, 1, 'San Marino'),
(196, 1, 'Sao Tome and Principe'),
(197, 1, 'Saudi Arabia'),
(198, 1, 'Senegal'),
(199, 1, 'Serbia and Montenegro'),
(200, 1, 'Seychelles'),
(201, 1, 'Sierra Leone'),
(202, 1, 'Singapore'),
(203, 1, 'Slovakia'),
(204, 1, 'Slovenia'),
(205, 1, 'Solomon Islands'),
(206, 1, 'Somalia'),
(207, 1, 'South Africa'),
(208, 1, 'South Georgia and The South Sandwich Isl'),
(209, 1, 'Spain'),
(210, 1, 'Sri Lanka'),
(211, 1, 'Sudan'),
(212, 1, 'Suriname'),
(213, 1, 'Svalbard and Jan Mayen'),
(214, 1, 'Swaziland'),
(215, 1, 'Sweden'),
(216, 1, 'Switzerland'),
(217, 1, 'Syria'),
(218, 1, 'Taiwan'),
(219, 1, 'Tajikistan'),
(220, 1, 'Tanzania, United Republic of'),
(221, 1, 'Thailand'),
(222, 1, 'Timor-leste'),
(223, 1, 'Togo'),
(224, 1, 'Tokelau'),
(225, 1, 'Tonga'),
(226, 1, 'Trinidad and Tobago'),
(227, 1, 'Tunisia'),
(228, 1, 'Turkey'),
(229, 1, 'Turkey'),
(230, 1, 'Turkmenistan'),
(231, 1, 'Turks and Caicos Islands'),
(232, 1, 'Tuvalu'),
(233, 1, 'Uganda'),
(234, 1, 'Ukraine'),
(235, 1, 'United Arab Emirates'),
(236, 1, 'United Kingdom'),
(237, 1, 'United States'),
(238, 1, 'United States Minor Outlying Islands'),
(239, 1, 'Uruguay'),
(240, 1, 'Uzbekistan'),
(241, 1, 'Vanuatu'),
(242, 1, 'Vatican City'),
(243, 1, 'Venezuela'),
(244, 1, 'Vietnam'),
(245, 1, 'Virgin Islands, British'),
(246, 1, 'Virgin Islands, U.S.'),
(247, 1, 'Wallis and Futuna'),
(248, 1, 'Western Sahara'),
(249, 1, 'Yemen'),
(250, 1, 'Yemen'),
(251, 1, 'Zambia'),
(252, 1, 'Zimbabwe');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tblleveringsmethodes`
--

CREATE TABLE IF NOT EXISTS `tblleveringsmethodes` (
  `LeveringsmethodeID` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `LeveringsmethodeNaam` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `LeveringsKosten` decimal(4,2) NOT NULL,
  PRIMARY KEY (`LeveringsmethodeID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Gegevens worden uitgevoerd voor tabel `tblleveringsmethodes`
--

INSERT INTO `tblleveringsmethodes` (`LeveringsmethodeID`, `LeveringsmethodeNaam`, `LeveringsKosten`) VALUES
(1, 'Morgen afgeleverd', '10.00'),
(2, 'Via de post', '7.50'),
(3, 'Benelux (taxipost)', '7.50');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tblprodpercategorie`
--

CREATE TABLE IF NOT EXISTS `tblprodpercategorie` (
  `ProdPerCategorieID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `CategorieID` smallint(5) unsigned NOT NULL,
  `ProductID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ProdPerCategorieID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=125 ;

--
-- Gegevens worden uitgevoerd voor tabel `tblprodpercategorie`
--

INSERT INTO `tblprodpercategorie` (`ProdPerCategorieID`, `CategorieID`, `ProductID`) VALUES
(102, 0, 80),
(109, 0, 79),
(101, 0, 80),
(108, 0, 79),
(103, 6, 80),
(107, 4, 79),
(111, 0, 81),
(110, 4, 81),
(112, 0, 81),
(113, 0, 82),
(114, 0, 82),
(115, 6, 82),
(116, 0, 83),
(117, 0, 83),
(118, 6, 83),
(124, 6, 84),
(123, 0, 84),
(122, 0, 84);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tblproducten`
--

CREATE TABLE IF NOT EXISTS `tblproducten` (
  `ProductID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Status` tinyint(1) unsigned NOT NULL,
  `AuteursID` mediumint(8) unsigned NOT NULL,
  `UitgeverijID` smallint(5) unsigned NOT NULL,
  `ProductPrijs` decimal(7,2) NOT NULL,
  `ProductPromoPrijs` decimal(7,2) NOT NULL,
  `ProductVoorraad` smallint(5) NOT NULL,
  `ProductAantalVerkocht` mediumint(8) NOT NULL,
  `ProductNaam` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ProductOmschrijving` text COLLATE utf8_unicode_ci NOT NULL,
  `ProductISBN` char(13) COLLATE utf8_unicode_ci NOT NULL,
  `ProductPublicatie` date NOT NULL,
  `ProductTaal` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ProductAantalpaginas` smallint(5) NOT NULL,
  `ProductExtra` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ProductTimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ProductID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=85 ;

--
-- Gegevens worden uitgevoerd voor tabel `tblproducten`
--

INSERT INTO `tblproducten` (`ProductID`, `Status`, `AuteursID`, `UitgeverijID`, `ProductPrijs`, `ProductPromoPrijs`, `ProductVoorraad`, `ProductAantalVerkocht`, `ProductNaam`, `ProductOmschrijving`, `ProductISBN`, `ProductPublicatie`, `ProductTaal`, `ProductAantalpaginas`, `ProductExtra`, `ProductTimestamp`) VALUES
(84, 1, 2, 2, '50.00', '0.00', 60, 0, 'Harry Potter 5', 'test', '9999999999999', '2005-05-01', 'Nederlands', 303, 'test', '2013-06-13 17:15:26'),
(79, 1, 2, 2, '60.00', '50.00', 9, 11, 'Aspe - Alibi', 'test', '9999999999999', '2002-05-02', 'Nederlands', 202, 'test', '2013-06-14 19:29:42'),
(80, 1, 1, 2, '60.00', '50.00', 13, 7, 'Blinker', 'test', '9999999999999', '2002-05-02', 'Nederlands', 202, 'test', '2013-06-14 19:30:44'),
(81, 1, 1, 2, '20.00', '0.00', 30, 0, 'Aspe - Aspe', 'test', '9999999999999', '2002-02-02', 'Nederlands', 102, 'test', '2013-06-13 17:06:55'),
(82, 1, 2, 2, '20.00', '0.00', 20, 0, 'Grote vriendelijke reus', 'test', '9999999999999', '2002-02-02', 'Nederlands', 101, 'test', '2013-06-13 17:09:46'),
(83, 1, 2, 2, '15.00', '0.00', 60, 0, 'Mathilda', 'test', '9999999999999', '1991-01-01', 'Nederlands', 150, 'test', '2013-06-13 17:11:10');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tbltempbestellingen`
--

CREATE TABLE IF NOT EXISTS `tbltempbestellingen` (
  `TempBestelID` bigint(15) unsigned NOT NULL AUTO_INCREMENT,
  `SessionID` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `TempBestelDatum` datetime NOT NULL,
  `AdresIP` varchar(39) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`TempBestelID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tbltempbestellingendetail`
--

CREATE TABLE IF NOT EXISTS `tbltempbestellingendetail` (
  `tempBestellingDetailID` bigint(15) unsigned NOT NULL AUTO_INCREMENT,
  `SessionID` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `ProductID` int(10) NOT NULL,
  `ProductAantal` smallint(5) NOT NULL,
  `ProductPrijs` decimal(10,2) NOT NULL,
  PRIMARY KEY (`tempBestellingDetailID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tbluitgeverij`
--

CREATE TABLE IF NOT EXISTS `tbluitgeverij` (
  `UitgeverijID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `Status` tinyint(1) unsigned NOT NULL,
  `UitgeverijNaam` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `UitgeverijOmschrijving` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`UitgeverijID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Gegevens worden uitgevoerd voor tabel `tbluitgeverij`
--

INSERT INTO `tbluitgeverij` (`UitgeverijID`, `Status`, `UitgeverijNaam`, `UitgeverijOmschrijving`) VALUES
(2, 1, 'Averbode', 'de uitgeverij averboden');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
