-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2022-05-19 23:59:30
-- サーバのバージョン： 10.4.22-MariaDB
-- PHP のバージョン: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `anime`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `goods`
--

CREATE TABLE `goods` (
  `id` int(32) NOT NULL COMMENT 'ID',
  `user_id` varchar(32) NOT NULL COMMENT 'ユーザーID',
  `review_id` int(32) NOT NULL COMMENT 'レビューID',
  `delete_flg` int(1) NOT NULL DEFAULT 0 COMMENT '表示・非表示',
  `title` varchar(255) NOT NULL,
  `recommended` int(32) NOT NULL,
  `story_pt` int(32) NOT NULL,
  `pictures_pt` int(32) NOT NULL,
  `music_pt` int(32) NOT NULL,
  `character_pt` int(32) NOT NULL,
  `overview` varchar(512) NOT NULL,
  `file_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `reviews`
--

CREATE TABLE `reviews` (
  `id` int(32) NOT NULL COMMENT 'ID',
  `user_id` varchar(255) NOT NULL COMMENT 'ユーザーID',
  `title` varchar(255) NOT NULL COMMENT 'タイトル',
  `recommended` int(32) NOT NULL COMMENT 'おススメ度',
  `story_pt` int(32) NOT NULL COMMENT 'ストーリー',
  `pictures_pt` int(32) NOT NULL COMMENT '作画',
  `music_pt` int(32) NOT NULL COMMENT '音楽',
  `character_pt` int(32) NOT NULL COMMENT 'キャラクター',
  `category` varchar(255) NOT NULL COMMENT 'カテゴリー',
  `overview` varchar(512) DEFAULT NULL COMMENT '概要',
  `file_name` varchar(255) NOT NULL COMMENT 'アニメイメージ',
  `file_path` varchar(255) NOT NULL COMMENT 'ファイルパス',
  `created_at` datetime DEFAULT NULL COMMENT '登録日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(32) NOT NULL COMMENT 'ID',
  `user_id` varchar(255) NOT NULL COMMENT 'ユーザID',
  `name` varchar(255) NOT NULL COMMENT 'ニックネーム',
  `password` varchar(255) NOT NULL COMMENT 'パスワード',
  `role` int(11) NOT NULL DEFAULT 0 COMMENT '管理者ID',
  `created_at` date DEFAULT current_timestamp() COMMENT '登録日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `goods`
--
ALTER TABLE `goods`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- テーブルの AUTO_INCREMENT `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT COMMENT 'ID';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
