-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Окт 24 2013 г., 23:02
-- Версия сервера: 5.5.32-0ubuntu0.13.04.1
-- Версия PHP: 5.4.9-4ubuntu2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `rzwebsys6`
--

-- --------------------------------------------------------

--
-- Структура таблицы `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `key` varchar(128) NOT NULL,
  `value` text NOT NULL,
  `field` varchar(32) NOT NULL,
  `data` varchar(256) NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `config`
--

INSERT INTO `config` (`id`, `title`, `key`, `value`, `field`, `data`, `sort`) VALUES
(1, 'Имя сайта', 'siteName', 'RzWebSys6', 'textFieldRow', '', 100),
(2, 'Email администратора', 'adminEmail', 'webadmin87@gmail.com', 'textFieldRow', '', 200);

-- --------------------------------------------------------

--
-- Структура таблицы `iblocks`
--

CREATE TABLE IF NOT EXISTS `iblocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `backend_controller` varchar(32) NOT NULL,
  `fronted_controller` varchar(32) NOT NULL,
  `fronted_action` varchar(32) NOT NULL,
  `relations` text NOT NULL,
  `tabs` text NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `iblocks`
--

INSERT INTO `iblocks` (`id`, `type_id`, `title`, `code`, `backend_controller`, `fronted_controller`, `fronted_action`, `relations`, `tabs`, `active`) VALUES
(2, 1, 'Новости', 'news', '', '/news/', '', '', '{"text": "Текст"}', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `iblock_news`
--

CREATE TABLE IF NOT EXISTS `iblock_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `mtime` datetime NOT NULL,
  `active` tinyint(1) NOT NULL,
  `title` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `annotation` text NOT NULL,
  `text` text NOT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `iblock_news`
--

INSERT INTO `iblock_news` (`id`, `author_id`, `mtime`, `active`, `title`, `code`, `image`, `annotation`, `text`, `date`) VALUES
(1, 4, '2013-10-24 22:09:02', 1, 'Кошки', 'koshki', 'koshki_119.jpg|0_6429_4922a0d9_XL.jpg|g70327.jpg', 'Считается, что первыми одомашнили кошек египтяне. По данным других исследователей, домашняя кошка появилась в результате скрещивания евро-африканской дикой кошки и камышового кота. Это животное условно называют "бабустис" — по месту знаменитого захоронения кошек в Древнем Египте.', '<p>В Бабустисе (Нижний Египет), в центре культа богини Бастет, кошки жили в храме и уход за ними был особо почетным делом, передающимся от отца к сыну. За кошками заботливо присматривали сами жрецы. Этому божеству поклонялись в храме Солнца в Гелиополе.</p>\r\n<p>В истории описаны случаи коварного использования такого поклонения египтян кошкам. Так, в 525 г. до н. э. персидский царь Камбиз, завоевывая Египет, приказал отловить как можно больше кошек и раздать их воинам, которые привязали их к своим щитам. Египтяне не стали сражаться с противниками, на щитах которых шипели и вопили кошки, а сдались в плен.</p>\r\n<p>Египетская богиня плодородия Бает В Египте казнили людей, умышленно убивших хотя бы одного "священного сторожа хлебных амбаров". Непреднамеренное убийство кошки наказывалось большим штрафом.</p>\r\n<p>Богиню Бает, почитавшуюся как символ счастья, любви и деторождения, изображали с кошачьей головой. В образе рыжего кота нередко египтяне запечатлевали и великого бога солнца Ра.</p>\r\n<p>Мореплаватели-финикийцы брали кошек с собой в путешествия. Домашние кошки начали быстро распространяться по всему миру. Наверняка мало кто знает, что символом восстания Спартака был свободолюбивый кот.</p>\r\n<p>Греки, ранее безуспешно боровшиеся с грызунами с помощью змей и хорьков, охотно стали использовать в этих целях кошек, контрабандно привозимых из Египта. Так кошки попали на Апеннины, а затем &mdash; в Грузию и на европейский рынок.</p>\r\n<p>В Британии, куда кошек завезли, по-видимому, римляне, останки домашней кошки найдены в развалинах дома IV в. до н. э., а первые письменные упоминания о них относятся к 936 г., когда правитель Южного Уэльса принял закон о защите этих животных. Кошек разрешалось содержать в монастырях.</p>\r\n<p>В Новом Свете первые изображения кошек были найдены в Перу, относятся они к 400-1000 гг. н. э., позднее они становятся постоянным мотивом в ювелирных изделиях, однако происхождение домашней кошки в этой части планеты все еще остается загадкой.</p>\r\n<p>К началу эпохи Средневековья кошек стало на планете так много, что они почти полностью утратили свое привилегированное положение. Церковь считала кошек олицетворением зла. Их сжигали на кострах, топили, зверски истязали и истребляли. Появился даже обычай замуровывать кошку в фундаменте строящегося здания. А в момент коронации Елизаветы I в 1558 г. в Англии прилюдно было сожжено несколько мешков с кошками.</p>', '2013-10-24'),
(2, 4, '2013-10-24 22:09:11', 1, 'Сибирские кошки', 'syberia-cats', '', 'Какого зверя сразу представляет житель России, услышав словосочетание "Сибирская кошка"? На ум тотчас приходит образ очень крупной, пушистой кошки с зелеными глазищами. А главное сразу думается: "Это наша кошка"!', '<p>Про Сибиряков часто говорят, что это исконно русская порода. Что ж, сейчас многие, не задумываясь, поставят знак равенства между словами Русь и Сибирь. Только давайте не будем забывать, что Сибирь была присоединена к составу Русского государства при Иване Грозном (16 век) при помощи войска, возглавляемого талантливым атаманом Ермаком Тимофеевичем. Русские войска не столько завоевывали Сибирь, сколько освобождали ее земли от владычества татарских ханов. Этим небольшим экскурсом в историю государства Российского мы хотим сказать, что Русским Духом в Сибири пахнет не дольше, чем европейским в Новом Свете.</p>', '2013-10-03');

-- --------------------------------------------------------

--
-- Структура таблицы `include_areas`
--

CREATE TABLE IF NOT EXISTS `include_areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `code` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=20 ;

--
-- Дамп данных таблицы `include_areas`
--

INSERT INTO `include_areas` (`id`, `section_id`, `title`, `code`) VALUES
(19, 0, 'Текст в левой колонке', 'leftcol');

-- --------------------------------------------------------

--
-- Структура таблицы `iproperty`
--

CREATE TABLE IF NOT EXISTS `iproperty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iblock_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `field` varchar(64) NOT NULL,
  `data_code` text NOT NULL,
  `list_code` text NOT NULL,
  `view_code` text NOT NULL,
  `show_in_list` tinyint(1) NOT NULL,
  `show_in_view` tinyint(1) NOT NULL,
  `show_filter` tinyint(1) NOT NULL,
  `editable` tinyint(1) NOT NULL,
  `type` varchar(32) NOT NULL,
  `sort` int(11) NOT NULL,
  `required` tinyint(1) NOT NULL,
  `relation` varchar(32) NOT NULL,
  `relation_name` varchar(64) NOT NULL,
  `relation_model` varchar(64) NOT NULL,
  `tab` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `iblock_id` (`iblock_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `iproperty`
--

INSERT INTO `iproperty` (`id`, `iblock_id`, `title`, `name`, `field`, `data_code`, `list_code`, `view_code`, `show_in_list`, `show_in_view`, `show_filter`, `editable`, `type`, `sort`, `required`, `relation`, `relation_name`, `relation_model`, `tab`) VALUES
(2, 2, 'Название', 'title', 'iTextFieldRow', '', '', '', 1, 1, 1, 1, 'VARCHAR(255)', 7, 1, '', '', '', 'element'),
(3, 2, 'Символьный код', 'code', 'iTextFieldRow', '', '', '', 1, 1, 1, 1, 'VARCHAR(255)', 6, 1, '', '', '', 'element'),
(4, 2, 'Изображения', 'image', 'iFileRow', '', 'array(\r\n            ''name'' => ''image'',\r\n            ''type'' => ''raw'',\r\n            ''value'' => ''"<img src=\\''".ImageResizer::r($data->getFirstFilePath(), 100)."\\'' alt=\\''\\''>"''\r\n)', 'array(\r\n            ''name'' => ''image'',\r\n            ''type'' => ''raw'',\r\n            ''value'' => "<img src=\\"".ImageResizer::r($model->getFirstFilePath(), 200)."\\" alt=\\"\\" />"\r\n)', 1, 1, 0, 0, 'TEXT', 5, 0, '', '', '', 'element'),
(5, 2, 'Аннотация', 'annotation', 'iTextAreaRow', '', '', '', 0, 0, 0, 0, 'TEXT', 3, 0, '', '', '', 'element'),
(6, 2, 'Текст', 'text', 'iHtmlRow', '', '', '       array(\r\n            ''name'' => ''text'',\r\n            ''type'' => ''raw'',\r\n            ''value'' => $model->text\r\n        )', 0, 1, 0, 0, 'TEXT', 2, 0, '', '', '', 'text'),
(7, 2, 'Дата', 'date', 'iDateRow', '', '', '', 0, 1, 1, 0, 'DATE', 4, 1, '', '', '', 'element');

-- --------------------------------------------------------

--
-- Структура таблицы `itypes`
--

CREATE TABLE IF NOT EXISTS `itypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `itypes`
--

INSERT INTO `itypes` (`id`, `title`) VALUES
(1, 'Новости');

-- --------------------------------------------------------

--
-- Структура таблицы `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `code` varchar(32) NOT NULL,
  `link` varchar(255) NOT NULL,
  `target` varchar(32) NOT NULL,
  `active` int(1) NOT NULL,
  `section_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `mtime` datetime NOT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `root` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `menu`
--

INSERT INTO `menu` (`id`, `title`, `code`, `link`, `target`, `active`, `section_id`, `author_id`, `mtime`, `lft`, `rgt`, `level`, `root`) VALUES
(1, 'Главное', 'main', '', '', 1, 0, 4, '2013-08-02 17:29:55', 1, 8, 1, 1),
(2, 'Главная', 'main', '/', '_self', 1, 0, 4, '2013-10-24 22:56:52', 2, 3, 2, 1),
(3, 'Кошки в средневековье', 'main', '/pages/cats/', '_self', 1, 0, 4, '2013-10-06 21:18:33', 4, 5, 2, 1),
(4, 'Новости про кошек', 'main', '/news/', '_self', 1, 0, 4, '2013-10-06 21:18:52', 6, 7, 2, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(32) NOT NULL,
  `model` varchar(32) NOT NULL,
  `create` int(1) NOT NULL,
  `read` int(1) NOT NULL,
  `update` int(1) NOT NULL,
  `delete` int(1) NOT NULL,
  `constraint` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Дамп данных таблицы `permission`
--

INSERT INTO `permission` (`id`, `role`, `model`, `create`, `read`, `update`, `delete`, `constraint`) VALUES
(17, 'user', 'User', 0, 0, 0, 0, ''),
(18, 'admin', 'User', 1, 1, 1, 1, 'return array(array("id"=>Yii::app()->user->id), array("role"=>"user"));'),
(20, 'user', 'Section', 0, 0, 0, 0, ''),
(21, 'admin', 'Section', 1, 1, 1, 1, 'return array(array("root"=>23));'),
(22, 'user', 'Menu', 0, 0, 0, 0, ''),
(23, 'admin', 'Menu', 0, 0, 0, 0, ''),
(24, 'user', 'IncludeArea', 0, 0, 0, 0, ''),
(25, 'admin', 'IncludeArea', 1, 1, 1, 0, ''),
(26, 'user', 'IblockNews', 0, 0, 0, 0, ''),
(27, 'admin', 'IblockNews', 0, 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `sections`
--

CREATE TABLE IF NOT EXISTS `sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `metatitle` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `depth` int(11) NOT NULL,
  `path` varchar(128) NOT NULL,
  `image` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `author_id` int(11) NOT NULL,
  `controller` varchar(128) NOT NULL,
  `action` varchar(128) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `root` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Категории' AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `sections`
--

INSERT INTO `sections` (`id`, `title`, `metatitle`, `keywords`, `description`, `code`, `parent_id`, `depth`, `path`, `image`, `text`, `author_id`, `controller`, `action`, `active`, `lft`, `rgt`, `level`, `root`) VALUES
(1, 'Главная', '', '', '', 'index', 0, 0, '', '', '<p align="justify">Кошка на Руси появилась в VII-VI вв. до н. э. Ее предположительно завезли торговцы и воины в Древнее государство Урарту и город Ольвию, которые имели обширные связи со Средиземноморьем. Скифы также знали домашних кошек. Гораздо позднее эти животные появились на побережье Балтийского моря (V-VIII вв.), и лишь в X-XIII вв. они оказались на территории Древней Руси, где быстро попали под защиту церковных законов. Кошка стоила дорого. В известном судебнике XIV в. "Правосудие митрополичье" сказано: "За украденное животное установлен штраф: за голубя &mdash; 9 кун; за утку, гуся и журавля &mdash; по 30 кун; за корову &mdash; 40 кун; за лебедя &mdash; 70 кун; за вола, собаку и кошку &mdash; по 3 гривны".</p>\r\n<p align="justify">В настоящее время Международной федерацией любителей кошек зарегистрировано в мире 36 пород и около 40 млн домашних кошек.</p>\r\n<p align="justify">Эти сведения дополняются и уточняются. Строгой статистики просто не существует. Однако считается, что в странах, где много кошек, на 4-5 семей (примерно на 17 человек) приходится хотя бы одна кошка.</p>\r\n<p align="justify">По некоторым литературным источникам (Рогожкина Л.Г., 1994), всего насчитывается уже более 100 пород, которые, вероятно, включают и те, что выведены методом породной селекции и официально еще не зарегистрированы, а также их помеси.</p>\r\n<p align="justify">На территории России обитает <strong>12 видов диких кошек</strong>: тигр, леопард, снежный барс, рысь, гепард, каракал, манул, бархатный кот, дальневосточный лесной кот, камышовый кот, степная (пятнистая) кошка и европейский лесной кот. Все виды диких кошек (за исключением северной рыси, камышового кота и кавказской лесной кошки) занесены в Красную книгу, охота на них полностью запрещена.</p>\r\n<p align="justify">Приручение домашних кошек происходило разными путями. И хотя в настоящее время в домашних условиях живут миллионы породистых и беспородных животных, есть много и бродячих кошек. Часто к этому приводит безразличное и невнимательное отношение к ним, длительное отсутствие владельцев. Они вынуждены искать приют от непогоды в самых разных укрытиях: на чердаках, в подвалах и т. д., самостоятельно находить себе пищу. Их число неуклонно возрастает. Часть бездомных животных, особенно в сельской местности, направляются в леса, дичают и становятся озлобленными. Их приходится отлавливать, так как они могут стать источником опасных болезней.</p>', 4, '/pages/', '', 1, 1, 2, 1, 1),
(2, 'Новости', '', '', '', 'news', 0, 0, '', '', '', 4, '/news/', '', 1, 1, 2, 1, 2),
(3, 'Статические страницы', '', '', '', 'pages', 0, 0, '', '', '', 4, '/pages/', '', 1, 1, 4, 1, 3),
(4, 'Кошки в средневековье', '', '', '', 'cats', 3, 0, '', '', '<p align="justify">К началу эпохи Средневековья кошек стало на планете так много, что они почти полностью утратили свое привилегированное положение. Церковь считала кошек олицетворением зла. Их сжигали на кострах, топили, зверски истязали и истребляли. Появился даже обычай замуровывать кошку в фундаменте строящегося здания. А в момент коронации Елизаветы I в 1558 г. в Англии прилюдно было сожжено несколько мешков с кошками.</p>\r\n<p align="justify">В XVII в. интерес к колдовству и "охоте на ведьм" снова возрастает, особенно в Англии. Король Яков I написал книгу о ведьмах и учредил должность "искателя ведьм". Преследование кошек перекинулось через Атлантику в американские колонии, где в штате Массачусетс в 1692 г. состоялись нашумевшие сэлемские процессы над ведьмами и их "нечистыми сношениями с кошками". Людям, любившим кошек, приходилось нелегко. Если они держали кошек, их обвиняли в связях с дьяволом, но стоило от них отказаться, грызуны мгновенно поедали запасы продовольствия, возбуждая эпидемии, болезни скота и людей.</p>\r\n<p align="justify">С началом эпохи Возрождения новомодный гуманизм распространился и на кошек, создающих уют в домах. Они вновь стали любимы людьми. Психологи начали изучать их поведение. Создавались книги и картины, посвященные кошкам. Достаточно назвать лишь несколько имен. Кошки занимают большое место в изобразительных творениях Гойя и Жана Батиста Грёза. В художественных работах использовали модную аллегорию, наделяли кошек человеческими чертами.</p>\r\n<p align="justify">К XVIII в. официальное преследование кошек прекратилось. Видный фелинолог Гаррисон Уэйр в 1889 г. писал, что кошка перенесла долгие годы и века презрения, дурного обращения и жестокости при полном отсутствии доброты и нежности; пришло время изменить порядок вещей. Именно Гаррисон Уэйр подал идею проведения кошачьих выставок, чтобы "новые породы, масти, отметины получали больше внимания". Он организовал и судил первую <strong>выставку кошек</strong> 16 июля 1871 г. в Хрустальном дворце Лондона, установил классы и "степени превосходства" для разных классов. Этим он надеялся улучшить внешний вид (экстерьер), а главное &mdash; судьбу кошек.</p>', 4, '/pages/', '', 1, 2, 3, 2, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `templates`
--

CREATE TABLE IF NOT EXISTS `templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `text` varchar(255) NOT NULL,
  `code` varchar(128) NOT NULL,
  `cond` varchar(255) NOT NULL,
  `cond_type` tinyint(4) NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `templates`
--

INSERT INTO `templates` (`id`, `title`, `text`, `code`, `cond`, `cond_type`, `sort`) VALUES
(1, 'Основной', '', 'index', '', 0, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `role` varchar(128) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `phone` varchar(16) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Пользователи' AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `name`, `image`, `phone`, `text`) VALUES
(4, 'root', '8e64a4f9bc126eaf21593bc08522b6eb', 'anton4912@gmail.com', 'root', '', 'cik.png', '', '');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `iproperty`
--
ALTER TABLE `iproperty`
  ADD CONSTRAINT `iproperty_ibfk_1` FOREIGN KEY (`iblock_id`) REFERENCES `iblocks` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
