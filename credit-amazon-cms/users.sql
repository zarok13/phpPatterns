-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 17, 2021 at 06:55 PM
-- Server version: 5.7.33-0ubuntu0.18.04.1
-- PHP Version: 7.2.34-13+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `number` varchar(15) DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `is_working` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `is_logged` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) DEFAULT NULL,
  `opened_requests` int(11) DEFAULT '0',
  `is_ganvadeba_user` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `number`, `password`, `is_working`, `enabled`, `is_logged`, `remember_token`, `opened_requests`, `is_ganvadeba_user`, `created_at`, `updated_at`) VALUES
(1, 'ADMIN', 'admin@admin.com', '558205245', '$2y$10$bLnlmXAc1oQu.b8WrSHsZ.WFbSnU2t/aSkBXMZJaa.VIRhAL7o0sm', 0, 1, 0, 'Qqu6LlbXNJKNyetDRqT8G23rdBpn4fEtQaWjPEqa3PACuUGOhRkGVkP4svVJ', 0, 0, '2018-05-03 00:51:30', '2020-09-25 18:53:11'),
(2, 'თაკო კარტოზია', 'kartozia@creditamazon.geq', '555711313', '$2y$10$LrC7Zl5rgV0bJ/xCL6GXIOS3vLYwiiCpCdZiLEoOZL8wXYrTrFet.', 0, 0, 0, 't0EbAfGPd08kc9GojzjiM9yYPtyGeAP7GcEKDJ5FAZWQtBxFmsVKYPtWbD4B', 0, 0, '2018-05-04 00:19:30', '2019-03-14 08:35:10'),
(3, 'თინანო უბირია', 'ubiria@creditamazon.geq', '557779398', '$2y$10$SB0.jM/ZAA6EQbmaGJmW2.vKUkpdORrEX6L6sQrRzLlI50w7tpO5K', 0, 0, 1, 'YNxZ70O1Brqcog4zt0hRQPOZvAD2MY7pqRbv9nwEBpz5sIZYj3ltfd08gnv4', 0, 0, '2018-05-07 06:23:35', '2019-04-23 04:53:54'),
(4, 'მარიამ  უზნაძე', 'uznadze@creditamazon.geq', '555004958', '$2y$10$yDI3J77vkNwkwIM4jghUdO25Awmcij3RZm2HG.q9sCkRHKlTf8VUG', 0, 0, 0, 'nA3lWkriL168PZaxWgIewhmHNk6GARug8psLdcJRnSxYHjLNt7g0d1zaKfLX', 0, 0, '2018-05-07 06:24:43', '2019-02-21 09:03:34'),
(5, 'ნათია ინასარიძე', 'inasaridze@creditamazon.ge', '557236312', '$2y$10$zb6Zs/.1ZGyAUh70tlkiKe.1IE8.StnlanGr0Y9.Avoe3Xo50DZq6', 0, 0, 1, '0cBztoyGQT0lPLUdLdE6A8oXgo8SHHWLSa4ErobFj1TFfUpHgOwslMjSBT6m', 0, 0, '2018-05-07 06:25:06', '2019-03-07 02:57:13'),
(6, 'ანანო იოსელიანი', 'ioseliani_old@creditamazon.geq', '557633324', '$2y$10$hVprghgAjSSH8bRE5g1PE.3anGZEevp/HB8RejDrviek7Q0kpb4Wu', 0, 0, 1, 'u21qCVekh34E9WVgCSs5loABfxfcDHwpyUU3w0VjlXQljawl25kbB7MvlAk1', 0, 0, '2018-05-07 06:25:30', '2019-02-18 05:37:16'),
(8, 'ნათია მაკასარაშვილი', 'makasarashvili@creditamazon.geq', '557769729', '$2y$10$Kfnk/nsAQFR7oKeGl9MGBOvMUwUBv6h0VHInNsf4VikyjRV7/3lcW', 0, 0, 0, 'EAKdrmAXDWM8uFjpr4TDDYUDR5eUf7DCbHduaqpQkDxjhRCfFaod92Rw2ctG', 0, 0, '2018-05-07 06:26:31', '2019-03-25 03:15:29'),
(9, 'ანა კუჭავა', 'kuchava@creditamazon.geq', '555711313', '$2y$10$WULOonEm/rji/trUEcXd.O0oedeppbp06jdfRstbawMPf5YDxeNfK', 0, 0, 0, 'LWmgKpHFb2wueF7Z8140FhoJB2eLxbpvoPGX6fhwi0ijtcguxMCszKQYHRXk', 0, 0, '2018-05-07 06:26:57', '2019-03-27 02:07:20'),
(10, 'ბუღალტერი', 'bugalteria@creditamazon.ge', NULL, '$2y$10$sjRgpeJScEm6Ya7Zb1/7deSBY/p.a60l1Hbr0Rd0na2DiRMcy5EsO', 0, 0, 0, '7h2qqfksv961RPiLBIZuHe9SxafDjaxl6CGADz7vRryxFaBay9Q3AJSd58W9', 0, 0, '2018-05-07 06:27:28', '2020-09-28 06:11:09'),
(11, 'techplus', 'techplus', NULL, '$2y$10$sjRgpeJScEm6Ya7Zb1/7deSBY/p.a60l1Hbr0Rd0na2DiRMcy5EsO', 0, 0, 0, 'T5jaazu0L1BBbr7VPncJzKCPLu11rnYg7bPq8uAAeMPGZJU9EoC43YqKJxp1', 0, 0, '2018-05-07 06:28:13', '2020-05-05 08:07:19'),
(12, 'ქეთა დურგლიშვილი', 'durglishvili@creditamazon.geq', '557633314', '$2y$10$81G7XNMWBJSmXs4Z1BNHVOwm/ASD2yvB0XU/Y5p7t.XbbTjlGOpAe', 0, 0, 1, '66Fb4Sjd4ab60eJcI84l2AahKhEfOfI9HgtcEIzv8CLrQuMsGiySuurEW6FY', 0, 0, '2018-05-07 06:29:06', '2019-03-18 02:38:52'),
(13, 'თაკო ყურაშვილი', 'yurashvili_oldaccount@creditamazon.ge', '555555555', '$2y$10$sjRgpeJScEm6Ya7Zb1/7deSBY/p.a60l1Hbr0Rd0na2DiRMcy5EsO', 0, 0, 0, NULL, 0, 0, NULL, '2019-01-30 06:01:58'),
(15, 'ნათია ცოფურაშვილი', 'tsopurashvili@creditamazon.geq', '558555421', '$2y$10$NQwgpPJOkWQ/jq0Ak.xzPODSlOdYneDPpLcQuchbmWrBYCjxF76Kq', 0, 0, 1, 'eCWMfdhSzRIRShhvKaethoXyO5UgrHdndZZ8faLEZGpP0UjUQkRAAERCmUz5', 0, 0, '2018-07-21 02:53:40', '2019-03-18 06:29:40'),
(16, 'სალომე ქოქიაშვილი', 'qoqiashvili_oldaccount@creditamazon.ge', '557633314', '$2y$10$pFnttpHmRpKAbrGSWIUtkOlxz0qKuwrGsGuNm0ZpXkpnFnyRPyfpu', 0, 0, 0, 'ka62NS8P85J80SsFNAOUrclZjMw2EzUODZxkPaq0ImJXJ3H4NrMpJhdXIvJA', 0, 0, '2018-07-21 03:54:45', '2019-01-30 06:02:13'),
(17, 'ქეთევან მაისურაძე', 'maisuradze@creditamazon.geq', '557309362', '$2y$10$vbcah55ovoQUaeHyVXd8p.Vm/4zFMDBN3BYh3WxH0J3QhyY23x0Kq', 0, 0, 1, 'gxeBlhZV3VP103pSV36OWG1mJ1f6yErap7lhWUgONTtgeODTNvbBwzphH1MA', 0, 0, '2018-11-14 16:00:00', '2019-03-07 02:57:10'),
(18, 'მანანა ლომთათიძე', 'lomtatidze@creditamazon.ge', '558205245', '$2y$10$8aP/XDYv4rLMVnKcrK8o0Ok4RXNIez4GIRUP6.Zij8WJBA9MFGnWa', 0, 0, 0, 'C5pbotsGsXUyFKwDv1nhcdnxEXQYWwK46rFAja6Hh4tj6bz44W3xIBXGdKw2', 0, 0, '2019-01-26 03:25:07', '2019-01-28 05:33:43'),
(19, 'ანა თარალაშვილი', 'taralashvili@creditamazon.ge', '558205245', '$2y$10$V.UMCPvnQ0oxMniBDVhiwuFAopliEzHxEJVaBkL81c3/OQ/K4eJsO', 0, 1, 0, '11QOPJb1ZPS91UMuLCkhsTdx9qFGVTDK6VEZu2Pv4vv9zJDCNb29ZqRYK2AW', 0, 0, '2019-01-26 03:25:07', '2020-08-17 07:08:10'),
(20, 'ილია ბერუაშვილი', 'beruashvili@creditamazon.ge', '558205245', '$2y$10$MFCC3ziDCT/RLp/bOkuyfu3Yoy0FITtMPJtLIGZpuI.acY3Mu1cKK', 0, 1, 0, 'cARJtnMnABtwf7T77PPRF93fslBqR9AE3D4E9UYxwp9H8egO1YWy71oxsaix', 0, 0, '2019-01-26 03:25:07', '2020-02-03 07:26:07'),
(21, 'ავთანდილი ნავროზაშვილი', 'navrozashvili@creditamazon.ge', '558205245', '$2y$10$O8iGuc.pM442Qfl0Yan6F.pTphsMCystUXMJVxQki93FKkQAKqOdm', 0, 1, 0, 'WRWdF4nWrmN2A309dIPYVTORYdvOwpGUnXWqURGI7vl0PpjkcJ2hr19hbFIg', 0, 0, '2019-01-26 03:25:07', '2020-09-26 13:56:19'),
(22, 'ვიქტორია ბასილაძე', 'basiladze@creditamazon.ge', '558205245', '$2y$10$XCbFjPg1PyGdUPnZgRerNuffB502ZjiEwqTDfjJ5NrqRGO/Fqaw46', 0, 1, 1, 'ykJY1DpYMR7RfNAPAzjN91zviNcZxcShWGwMC7iakO5DKkMudskBZjQ8VlE0', 0, 0, '2019-01-26 03:25:07', '2019-06-06 02:54:33'),
(23, 'ხათუნა ქარდავა', 'kardava@creditamazon.ge', '591975390', '$2y$10$d0JD1UbAvfl.JmmO1owUaOPp2Cqnp/zRiAeX5rPRkhX7WuGrxwyMi', 0, 1, 0, 'S6jyEEhpjLv9KIvq0h0epw0VoNxakwvO0nYd1GRRdTv52Oqc2v81frYSyOMk', 0, 0, '2019-01-26 03:25:08', '2020-08-07 06:09:35'),
(24, 'თამარ ბიწაძე', 'bitsadze@creditamazon.ge', '558205245', '$2y$10$C68TJ.SrsmZq9HD1BVSxJOgEtGj/KaWFvUnzscJoVD9UFvXrGnTI2', 0, 1, 0, 'oAL4Ou7xHKiECzb6wpolkKZqkWgmxsTHDWmV0Xb7sR3FzsDFTwxjatl6znF8', 0, 0, '2019-01-26 03:25:08', '2020-08-07 06:23:56'),
(25, 'გიორგი ჩიკორაშვილი', 'chikorashvili@creditamazon.ge', '558205245', '$2y$10$mLirex6tc4eBb5NN5MTgxObk3umHsVd/aoZX/OtoN/5P5F1YJS2q.', 0, 1, 1, '0QregjW2R0TP0R6f3dgRBOQ85CwFXI8niKm4IfiFsQG4w1irYKihhPdhmgIC', 0, 0, '2019-01-26 03:25:08', '2019-04-05 06:43:04'),
(26, 'მარიამ მენოგნიშვილი', 'm.menognishvili@creditamazon.ge', '555024932', '$2y$10$USrVPuBO0TpWagY9ME8G7OGvOkMiQZ17N6vNnzQo4CwPRHzcA1sWK_OLD', 0, 0, 1, 'XZmDzK09vsNZXyoGWpIBil8Fjr3ARGeY6Tx1rPeyOkL0SkmkJqrmnthNB59b', 0, 0, '2019-01-28 04:06:40', '2019-07-05 09:59:36'),
(27, 'ლიპარტელიანი გვანცა', 'liparteliani@creditamazon.ge', '557779398', '$2y$10$zRuw/MVwnOx4K3rFyBF5cuvaJTiSf733USU0qBd9ygj7CNI5PYvYa', 0, 0, 1, 'tPJZ8iQou3NmBhrI8SMRHHmE4rLldXE0EAqRhJU1stUlfesG4xWV8cclFicV', 0, 0, '2019-02-18 03:17:57', '2019-07-05 10:08:55'),
(29, 'ლევან აბესაძე', 'abesadze@creditamazon.ge', '557779398', '$2y$10$2dJFaShr./ygqBULsPJQ2uOtNOl7/GjZfCf3Cl4DMNJMkxxzjxZeu', 0, 1, 0, 'WHGm1y9kQEtteiYu071USb2EKkFnujFuIP3MsYzNajKkfsUETkYp29SIl8Uu', 0, 0, '2019-02-18 05:37:31', '2020-09-24 15:24:08'),
(30, 'მარი დევიძე', 'devidze@creditamazon.ge', '111111111', '$2y$10$wW7u1uBWFAnDPaSLsEfjCeGZPviM.FBvrfpu/DfLdWbQhoQ2ossXG', 0, 1, 0, 'Et0VMhyexkbDxah71YTs6DnxSFsMijw3jeOlGcagVmwmbjR7anvgedPQCibt', 0, 0, '2019-03-12 10:15:39', '2020-08-18 10:58:10'),
(31, 'ანა ლეკიაშვილი', 'lekiashvili@creditamazon.ge', '557633314', '$2y$10$mbihkWc.yJHmgIeKWavjnOORtFoOujVCqD6k99hA78Jx7GJ3U2ngO', 0, 1, 0, 'oRsqzJWIeavxgBnI3AGNLUHk9wqJdjq4o7806LdP1rN8DdyQ9tfAJczDLSCC', 0, 0, '2019-03-25 16:00:00', '2020-08-06 06:15:45'),
(32, 'გიორგი ხომერიკი', 'khomeriki@creditamazon.ge', '558205245', '$2y$10$CJoxxF9.ymsxWvjacY7uKugLWLZ5Qlf6qEZEnd25uUC5FMZTXiugy', 0, 0, 1, 'kEl9g5g1qkYd3t4kQLl4XQf2PkMnaJjs0aFsNLrluRoDPZoyX6tWLhyPXDbJ', 0, 0, '2019-03-25 16:00:00', '2019-07-08 07:12:52'),
(33, 'გვანცა ხაბაზიშვილი', 'khabazishvili@creditamazon.ge', '557309362', '$2y$10$29vwdrI2Y8QP7Nq8s3JOR.SgYFAbY9xRMRe2kvIyJt0QZegosNw3O', 0, 1, 0, '1aSIzSpFW6vAxeZjf51zw9rjKft5EwfitpCGddI9a2uun6ynjYWphnmsVcSl', 0, 0, '2019-03-25 16:00:00', '2020-04-04 06:59:53'),
(34, 'აკაკი პაიჭაძე', 'paichadze@creditamazon.ge', '557769729', '$2y$10$rPfBgmRb5NyLl2fjBTI.j.DHoQaS3pp7qfrqAkt3X6UGNTE8ODpcm', 0, 0, 1, 'Nw0I3JShjxalJZRd1n7Jop57mIN8QwjjSh536LNTM07X7nJFxG1vhPo0yDpl', 0, 0, '2019-03-25 16:00:00', '2019-05-24 03:27:11'),
(35, 'ოთარ არონია', 'aronia@creditamazon.ge', '555004958', '$2y$10$2qwWjxefOk52CwNXCrYIruAZynE2NRgZp.Cy4rx7EGOlALM5NmOxq_OLD', 0, 0, 0, 'nhlTC0wUR0fAE6tmOMv6wcQA7fTpCoeIoX6q07kzcX7TlP1pdENNr9Jyt9z9', 0, 0, '2019-02-18 03:17:57', '2020-04-30 14:06:48'),
(36, 'ანა გოგიძე', 'gogidze@creditamazon.ge', '591685199', '$2y$10$xMk76lzaL.Gyg198tRvbSOUwLbgaaAilM5hQtj1PR36y1h1UkDJw.', 1, 1, 0, 'vHg86ScqiMuwaO8yuSueapefZf1YPC1IT4udzPC8gIpwBtLOj6jIEryGyf27', 0, 0, '2019-02-18 03:17:57', '2021-01-27 08:40:46'),
(37, 'ანა ბაქრაძე', 'bakradze@creditamazon.ge', '591685280', '$2y$10$3ceqiKN9DHN5WtjouFNV5uWT/zAxoDnhWM.kl5UMb6qrivmQBpH2q', 1, 1, 0, 'lS2ABOPkuHJSZ1qh0aeYQp5is5piGgERYDnDnh2TxDQy1UHTpHg4mVb1ohbt', 0, 0, '2019-02-18 03:17:57', '2021-01-28 07:55:35'),
(38, 'ანა კოშორიძე', 'koshoridze@creditamazon.ge', '557309362', '$2y$10$2qwWjxefOk52CwNXCrYIruAZynE2NRgZp.Cy4rx7EGOlALM5NmOxq', 0, 0, 0, 'hDaIkue2uhDPQ9L4opUxfdmGvaMMfqZACqVkwOlAiPVk3GwoF97NOSvvDPYu', 0, 0, '2019-02-18 03:17:57', '2020-06-10 08:39:01'),
(39, 'ანა კოკელაძე', 'kokeladze@creditamazon.ge', '591684940', '$2y$10$Cgj1ai6fRudPj7WrSqhOrOQE/p8hw7eq33CStPCYf0t6AykC4dR6m', 1, 1, 1, '5Stx4xywo5LagrRGH4026W0aAPgtH7GTYAQ6Q4qGxSp4CgBgPORDPxKj3xjj', -2, 0, '2019-02-18 03:17:57', '2021-01-24 15:14:15'),
(40, 'მარიამ მოდებაძე', 'modebadze@creditamazon.ge', '555024932', '$2y$10$vjGq5UHdxCY4o2ILqRjnSOvUNPJ9na1xFPcf5flvs.iySeU/6QOTC', 0, 0, 1, NULL, 0, 0, '2019-02-18 03:17:57', '2020-03-06 15:00:53'),
(41, 'ნინო გელაძე', 'geladze@creditamazon.ge', '591975384', '$2y$10$nfVm8LwZwwdspmcpmKUipO2nWsk0FoG6FcdVgyNB/GF.Z18euWnm.', 0, 0, 0, '1ZeP7zjkauISQVP1Dzu1OEopfTIGGr9mGWCPgaEZeaTQILruCMeaXVte5DSk', -1, 0, '2019-02-18 03:17:57', '2020-09-15 15:25:59'),
(42, 'გიგა უსენაშვილი', 'usenashvili@creditamazon.ge', '557633324', '$2y$10$8Za2WC3gzNfiNmmry7JgmOr/mXJ3XKKT22mPBRY2LTJeoMEHrESfu', 0, 0, 0, 'FoHhI3C6L1lodXMhZfAy7ACsIIL9MGz5hbyByt01oz7eFYNB9QGukrFJlIse', 0, 0, '2018-05-07 10:25:30', '2020-10-05 07:08:47'),
(43, 'გია ღვინიაშვილი', 'gviniashvili@creditamazon.ge', '557633324', '$2y$10$1MU4MkYt0l4O5i/R7UwtV.hZtyXAKS8wmao09VeUWmr0a4Bw/onu2', 0, 0, 0, 'LUGq908iFGAureQJLufdXb88twmgSkExDxoMMMRYDpq5JfxYBWMP7VdeF8ja', 0, 0, '2018-05-07 10:25:30', '2020-08-05 13:30:28'),
(44, 'დავით ელბაქიძე', 'elbakidze@creditamazon.ge_old', '557779398', '$2y$10$cco5UKnQvkZ2wg814.8F3OKois/IpQTcI3hpuqVSc.SgLuAlZnKai_old', 0, 0, 0, 'dxZY9k1UFxFnPv0vavbdKOPO70dLztNbn5WmLQek1BewTQD2WwIibpm4bmfC', -1, 0, NULL, '2020-07-31 14:15:11'),
(45, 'თამარ გაბათაშვილი', 'gabatashvili@creditamazon.ge', '558206134', '$2y$10$ANs0bS06CQgGDihagUJ1f.huosBrAFG4TvYn.rk3zJsWg2buTyXzi', 0, 0, 0, 'iQKeqnxi1CRSXBRXrJvWDCQxMgsNeAf8hr1k2DOAJqX6eej32qzXgAUQKjnP', 0, 0, NULL, NULL),
(46, 'ნათია გოგუა', 'gogua@creditamazon.ge', '555004958', '$2y$10$tY9x1R7LXtdY1sbdgif9J.a6Juci3iOQNmKBd7r2CRN2EtllEGkEq', 0, 1, 0, 'cZjXLAvs0pl5PUwSAy6eLyVhxrL824pYQcyUIvuolqLdN1ifBI6nTEdGojMS', -3, 0, NULL, '2021-01-15 07:47:07'),
(47, 'ანა ოქროპირიძე', 'okropiridze@creditamazon.ge', '557309362', '$2y$10$9twOfEx1c3o4imJkmm1WCOVnYIRU9HJjnMmM4.JQyaLRnIa.VX0xK', 0, 1, 1, 'aax86o5vDl3tcgqx2CmGo7OfnaVQO9GSlbux76NZT3LbGeiqhCrC1RytEsiN', 0, 0, '2019-03-25 16:00:00', '2020-11-06 11:21:08'),
(48, 'დავით ბაკურაძე', 'bakuradze@creditamazon.ge_old', '558205245', '$2y$10$MFCC3ziDCT/RLp/bOkuyfu3Yoy0FITtMPJtLIGZpuI.acY3Mu1cKK_old', 0, 1, 0, 'mGOyHWHal0xDJYJPgef2z4oTkuOcZAaRkjOIOqjcXLkgDKbeDeA4cuzXXjAX', 0, 0, '2019-01-26 03:25:07', '2020-02-03 07:26:07'),
(49, 'ქეთი წერეთელი', 'tsereteli@creditamazon.ge', '557309362', '$2y$10$UzxPN3xaTtBnbhIwthmi/u.9wcWzymubE/cva7L32855RsLFKjTau', 0, 1, 0, '3Uy13dAMGrs7jPcNXnnvwspU0KmnBQsu0t5GkC4RudYBX4DE0nqk0umVCIqp', 0, 0, '2019-03-25 16:00:00', '2020-08-10 06:42:36'),
(50, 'ანა ჯანჯღავა', 'ajanjgava@creditamazon.ge', '558555421', '$2y$10$Kq3vm8Gun.PNvMIxdY7Qbuibz/vdAZNYDRf9OBwpXdZZ/JqFr0gnO', 1, 1, 0, 'tUhuUSYdv6qBYaqtO8YpYNxmzB52ReRBKY3xFRd9ROWA0Cxk6OBldTmekxR0', 1, 1, '2020-06-14 16:03:45', '2021-01-30 08:08:29'),
(51, 'მარიამ მაჭავარიანი', 'mmachavariani@creditamazon.ge', NULL, '$2y$10$UVBl9P/49LnrXrvMjBvyYOrI8653ND1KKPPkLce5wBUXWLpNtIFaa', 0, 0, 0, '4kXEtTLcTLoVPnZhJCJQ55cppZd7BT2Fmqpjq64TtvzaQL8aEUeCBN1iUAot', 0, 0, '2020-06-14 16:04:51', '2020-06-16 13:35:01'),
(52, 'შალვა გურაბანიძე', 'shgurabanidze@creditamazon.ge', '', '$2y$10$BjSfka6S2tShwaN2re0ElOU/TlJbn6siA1YKq4hvIvjNbjsR5DOpe', 0, 0, 0, 'gzsZM3L80Vk8yHMFhyKWu5mqzKAch1qK7eiGw3x8QbUk0G0vpOJM1fTn1xjI', -3, 0, '2020-06-14 16:25:03', '2020-06-16 13:07:13'),
(53, 'ნატო კუთხაშვილი', 'kutxashvili@creditamazon.ge', '555024932 ', '$2y$10$b4VA9a7XJkQvPU0KwVlzHuasrpfhWS1NToSaSSrpdz3j.ex91F0wW', 0, 0, 0, NULL, -6, 0, '2020-06-18 06:33:59', '2020-06-19 06:03:53'),
(54, 'ანანო აბულაძე', 'a.abuladze@creditamazon.ge_old', '557309362', '$2y$10$SuJ78rRRkWcavVFtdB.nBOW3Uc8bMrKvepGiisa5lk1RynaAH.oZS_old', 0, 0, 0, 'E4QAP8NEHRzG0wVWDeby21Jw23Llz2rnAeNLPUa9DAsq7OyLloyYYIXbD5ya', 0, 0, '2020-06-14 16:03:45', '2020-08-27 14:59:30'),
(55, 'ნინო ნოზაძე', 'n.nozadze@creditamazon.ge_old', NULL, '$2y$10$QMhm/bmmxEg.5t1jnNLtbO7N3AY2fS/Qz4.aH/6M3iS1IEFsPP3si_old', 0, 0, 0, NULL, 0, 1, '2020-06-14 16:03:45', '2020-07-13 06:30:03'),
(56, 'სალომე ტვილდიანი', 's.tvildiani@creditamazon.ge', '555004958', '$2y$10$Fo5yvt3cFESsNQGEeCqyRe5tN6MFgltVJGvQHeePO.HucFpWvlIEW', 0, 1, 0, 'fBGt3FFraXjnNNgJrz7kfl8ZIeRI5vx7mh3yn4Q2BhOWWHPm7i5sXDEUkKx4', -4, 1, '2020-06-14 16:03:45', '2021-01-28 19:03:11'),
(57, 'დაკო მიგრიაული', 'd.migriauli@creditamazon.ge_old', '555516258', '$2y$10$l/asr2cWi5Eb5HBb3djZ4OW.7ie6CV9XtsbpJP8JME6efJu0VudzG_old', 0, 0, 0, 'yNpP5falGEtBWQbJ82TTNeoRk0xMppc9js2quUAt9BeqBFUNq4UyoqP9mX6E', 0, 0, NULL, '2020-07-25 10:22:21'),
(58, 'ჩხაპელია თემური', 't.chkhapelia@creditamazon.ge_old', '555529133', '$2y$10$QMhm/bmmxEg.5t1jnNLtbO7N3AY2fS/Qz4.aH/6M3iS1IEFsPP3si_old', 0, 0, 0, 'pXiATp0kVsVQ6gc3ij2yuwcyNSyPHo1zjFR6DyIVucqP36WiPqDPxzLSmbkl', -1, 1, NULL, '2020-08-01 08:33:36'),
(59, 'იზა წიკლაური', 'i.tsiklauri@creditamazon.ge', '558205245', '$2y$10$2WYJsqBGbCdlT6AMs5AC1e2ubW.T4rQJBObeTkukF1ACqhiypdaGm', 0, 0, 0, 'srC4crAMTLEfQ8xcsvPDKNxx6I5vVUv6i2lrZWbEfcvXU1hceF0qiG5ejffx', 0, 0, '2020-06-29 07:46:45', '2020-09-28 07:22:09'),
(60, 'ნინი ლალიაშვილი', 'n.laliashvili@creditamazon.ge', '555024932', '$2y$10$dHINBDX.BWkhnW59/7.QFO77LH9CV.4YyyDVCAG9hMvdDXjAUdUwm', 1, 1, 0, 'j3YTv0OLF6dBTRDEiRx4dexUSTPgCSzB51BZYWGZgTS80Is35UrfF44TDDpu', 0, 0, NULL, '2021-01-30 08:09:26'),
(61, 'ნიკა ძიბელაშვილი', 'n.dzibelashvili@creditamazon.ge', '555986135', '$2y$10$wBxkuHhw28yeHQH93VLKkeuVMYvARqL5II7yp1ndZKrJt61DV2V9.', 0, 1, 0, 'IcU4v4xEYCfph5j3jOtD9q7sGggvL7PbGOqyqrYN1seJlkM4DGFv3hJV3OZ7', -3, 1, '2020-07-27 07:38:01', '2021-01-28 19:03:02'),
(62, 'ნათია ლაშქარაშვილი', 'n.lashqarashvili@creditamazon.ge', '557168875', '$2y$10$Tem2bMIJKNaDQn/15PBzUezYB.sE1Sq4UYSmq2DkNExpkeQBOJCDy', 1, 1, 1, '9MkYwEO39LF3bD0yE2ZU0u7FYjqDy43jQJw3WfiSDIEzH7NxSkVey4Ca0zDR', 1, 1, '2020-07-27 07:38:01', '2021-01-30 08:32:39'),
(63, 'ლიზა ტუგულაშვილი', 'l.tugulashvili@creditamazon.ge', '557189583', '$2y$10$iK4NF4ge.Jh1DyTl6A105OzfVyMv6e0YYekhyJtSq57.qvHGGYod6', 1, 1, 0, 'Ip7home2g1Ktu5MU3aJje4qcrAemdEKrghtZbvZXytFl0A0mh4HG4AtewPts', -1, 1, NULL, '2021-01-28 11:28:06'),
(64, 'ნიკა გოგელია', 'n.gogelia@creditamazon.ge', '555516258', '$2y$10$uMfS1KWUsBxqk8h94BcK3.fs2EaSATYq3HkfGIdv0Vr3OOopnUFtC', 1, 1, 0, '6ZK0x9SLLSU7w9oOA20fdC0vIwAGJ9cNbCdsNb6yIKq2yyfHyy8KgibP46ME', 0, 1, NULL, '2021-01-30 06:15:43'),
(65, 'სოფო პაიაშვილი', 's.paiashvili@creditamazon.ge', '558247800', '$2y$10$usZzD8yT3DrnDinUUw3rOeW84pgOgAjWZpp2iduJ1UeFYy4Nk.g.a', 1, 1, 0, 'yGgTZXwWKZKqNtvYZUvsIgThGWpLNF53x1HOy8pOxWvTkgFZ33H14FkkibEV', -1, 0, NULL, '2021-01-29 08:57:35'),
(66, 'მარიამ ლეკაშვილი', 'm.lekashvili@creditamazon.ge', '555452551', '$2y$10$s0RA8YR7jUxiFAvwmBY9KOC/BQ92s1M1D5NIj5C7fGLIhOBLU9cSS', 0, 1, 0, 'ADpVYvtoPeb3M1AKjKWa26BFphhoYbijhE2uTvrjgk6rRH7TWXppHwWX8rsG', -2, 0, NULL, '2021-01-28 19:02:41'),
(67, 'თამუნა სულხანიშვილი', 't.sulkhanishvili@creditamazon.ge', '557633314', '$2y$10$jf8sjqsFXgHfWRCntVzVMeBa4TjB5CCbhf7CtPXGZcWeX4aBpc7le', 0, 1, 0, 'g0Zld0E9d0ke6YqaRkdIYmqLQM3i4RE681bWFwZRG1wPNvG8aiQdOnCZ4soN', -1, 1, '2020-07-27 07:38:01', '2021-01-28 19:03:13'),
(68, 'ია კაციაშვილი', 'i.katsiashvili@creditamazon.ge', '557779398', '$2y$10$Zg/TtkyZ8tIZBWgjdttZqu515T6pbi8OO84wJp1aC3VMDkKMtqx1a', 1, 1, 1, 'VOKQOE0aGqZCFlVDi06G52jZvK3fMxUye5QMAgtY2c54wscS1SiPnnWf1H4p', 1, 1, '2020-07-27 07:38:01', '2021-01-30 07:01:16'),
(69, 'მიხეილ მშვილდაძე', 'mshvildadze@creditamazon.ge', '557779398', '$2y$10$dIBnVEzyF3bvAv0EdFIw3up6oeAr4/g9FUpvtV45I0ht1l9o4WQhm', 0, 1, 0, 'J5RzOPmsKVrhqI6vPk1ERkwawatQHwASvTBkCZphbU4cs7Y9z1gVh4uUHIDo', 0, 1, '2020-07-27 07:38:01', '2020-11-09 14:35:34'),
(70, 'სალომე გოგინავა', 'goginava@creditamazon.ge', '557633314', '$2y$10$rVw9bDoWvRtTuxdMbnla7e.MprsA4SztEMqmQ5q20QN7ziyOJl0Oi', 0, 1, 0, 'aGXdyxs5noxgoAuuPDWUmAMc8pkanQjeIhPzu0BFgkGIMj46Bosht6l8RbsR', 0, 0, '2019-03-25 16:00:00', '2020-08-06 06:15:45'),
(71, 'ნინო ჭელიძე', 'tchelidze@creditamazon.ge', '557309362', '$2y$10$/gU0F5ec5NzgveAckRoDE.uaAVxqSo3xTpQZIjiC5ZbBunb5wacpa', 0, 1, 0, '1aSIzSpFW6vAxeZjf51zw9rjKft5EwfitpCGddI9a2uun6ynjYWphnmsVcSl', 0, 0, '2019-03-25 16:00:00', '2020-04-04 06:59:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
