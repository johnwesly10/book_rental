

create database book_rental;
use book_rental;

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `key_slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `rent_amount` int(11) NOT NULL DEFAULT 20,
  `category` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `key_slug`, `title`, `author`, `description`, `rent_amount`, `category`, `image`, `created_at`) VALUES
(1, 'the-name-of-the-wind', 'The Name of the Wind', 'Patrick Rothfuss', 'A fantasy novel following the life of Kvothe, a gifted young man who grows into a legendary figure.', 25, 'Fantasy', 'images/name-of-the-wind.jpg', '2025-02-22 02:16:24'),
(2, 'the-way-of-kings', 'The Way of Kings', 'Brandon Sanderson', 'The first book in The Stormlight Archive, a high-fantasy series filled with intricate world-building and powerful characters.', 18, 'Fantasy', 'images/way-of-kings.jpg', '2025-02-22 02:16:24'),
(3, 'the-eye-of-the-world', 'The Eye of the World', 'Robert Jordan', 'The first book in The Wheel of Time series, an epic tale of magic, prophecy, and the battle between good and evil.', 21, 'Fantasy', 'images/eye-of-the-world.jpg', '2025-02-22 02:16:24'),
(4, 'mistborn', 'Mistborn', 'Brandon Sanderson', 'A gripping fantasy novel about a revolution in a world ruled by a seemingly immortal tyrant.', 15, 'Fantasy', 'images/mistborn.jpg', '2025-02-22 02:16:24'),
(5, 'wizards-first-rule', 'Wizard\'s First Rule', 'Terry Goodkind', 'The first book in The Sword of Truth series, following the journey of Richard Cypher as he discovers his destiny.', 21, 'Fantasy', 'images/wizards-first-rule.jpg', '2025-02-22 02:16:24'),
(6, 'red-white-royal-blue', 'Red, White & Royal Blue', 'Casey McQuiston', 'A romantic comedy about the First Son of the United States and a British prince who go from rivals to lovers.', 23, 'Romance', 'images/red-white-royal-blue.jpg', '2025-02-22 02:16:24'),
(7, 'book-lovers', 'Book Lovers', 'Emily Henry', 'A witty, heartwarming romance following a literary agent and a brooding editor who keep running into each other.', 17, 'Romance', 'images/book-lovers.jpg', '2025-02-22 02:16:24'),
(8, 'the-hating-game', 'The Hating Game', 'Sally Thorne', 'A charming enemies-to-lovers workplace romance between two competitive co-workers.', 20, 'Romance', 'images/the-hating-game.jpg', '2025-02-22 02:16:24'),
(9, 'happy-place', 'Happy Place', 'Emily Henry', 'A second-chance romance about a once-perfect couple pretending to still be together during a vacation with friends.', 15, 'Romance', 'images/happy-place.jpg', '2025-02-22 02:16:24'),
(10, 'funny-story', 'Funny Story', 'Emily Henry', 'A delightful and emotional romance about unexpected love and finding humor in heartbreak.', 23, 'Romance', 'images/funny-story.jpg', '2025-02-22 02:16:24'),
(11, 'a-confederacy-of-dunces', 'A Confederacy of Dunces', 'John Kennedy Toole', 'A satirical novel following the eccentric and misanthropic Ignatius J. Reilly as he navigates the absurdities of 1960s New Orleans.', 20, 'Humor', 'images/a-confederacy-of-dunces.jpg', '2025-02-22 02:16:24'),
(12, 'hyperbole-and-a-half', 'Hyperbole and a Half', 'Allie Brosh', 'A collection of humorous, autobiographical essays and illustrations based on the popular blog, covering topics like depression, childhood, and dogs.', 19, 'Humor', 'images/hyperbole-and-a-half.jpg', '2025-02-22 02:16:24'),
(13, 'tartufo', 'Tartufo', 'Molière', 'A classic French comedy about hypocrisy and deception, where a conman pretends to be a pious religious devotee to exploit a wealthy family.', 21, 'Humor', 'images/tartufo.jpg', '2025-02-22 02:16:24'),
(14, 'dirtbag-queen', 'Dirtbag, Massachusetts', 'Andy Corren', 'A raw and hilarious memoir that explores Corren’s unconventional life, blending humor, heartbreak, and resilience.', 21, 'Humor', 'images/dirtbag-queen.jpg', '2025-02-22 02:16:24'),
(15, 'i-made-it-out-of-clay', 'I Made It Out of Clay', 'Beth Kander', 'A contemporary novel that explores family, identity, and tradition, following the journey of self-discovery.', 16, 'Humor', 'images/i-made-it-out-of-clay.jpg', '2025-02-22 02:16:24'),
(16, 'the-book-thief', 'The Book Thief', 'Markus Zusak', 'A historical novel set in Nazi Germany, following Liesel Meminger as she steals books and shares them with others while Death narrates her story.', 23, 'Historical Fiction', 'images/the-book-thief.jpg', '2025-02-22 02:16:24'),
(17, 'all-the-light-we-cannot-see', 'All the Light We Cannot See', 'Anthony Doerr', 'A Pulitzer Prize-winning novel about a blind French girl and a German soldier whose paths cross during World War II.', 22, 'Historical Fiction', 'images/all-the-light-we-cannot-see.jpg', '2025-02-22 02:16:24'),
(18, 'the-nightingale', 'The Nightingale', 'Kristin Hannah', 'A gripping World War II novel that follows two sisters in Nazi-occupied France and their journey of survival and resistance.', 17, 'Historical Fiction', 'images/the-nightingale.jpg', '2025-02-22 02:16:24'),
(19, 'outlander', 'Outlander', 'Diana Gabaldon', 'A mix of historical fiction, romance, and time travel, following Claire Randall as she is transported from 1945 to 18th-century Scotland.', 25, 'Historical Fiction', 'images/outlander.jpg', '2025-02-22 02:16:24'),
(20, 'the-help', 'The Help', 'Kathryn Stockett', 'A powerful story set in 1960s Mississippi about African American maids sharing their experiences with a young white journalist.', 25, 'Historical Fiction', 'images/the-help.jpg', '2025-02-22 02:16:24'),
(21, 'the-big-empty', 'The Big Empty', 'Robert Crais', 'A thrilling crime novel featuring detective work, mystery, and action-packed investigation.', 24, 'Thriller', 'images/the-big-empty.jpg', '2025-02-22 02:16:24'),
(22, 'a-very-bad-thing', 'A Very Bad Thing', 'J.T. Ellison', 'A gripping psychological thriller filled with secrets, deception, and unexpected twists.', 18, 'Thriller', 'images/a-very-bad-thing.jpg', '2025-02-22 02:16:24'),
(23, 'in-too-deep', 'In Too Deep', 'Lee Child and Andrew Child', 'A Jack Reacher novel full of suspense and action as Reacher finds himself caught in a dangerous conspiracy.', 18, 'Thriller', 'images/in-too-deep.jpg', '2025-02-22 02:16:24'),
(24, 'perfect-storm', 'Perfect Storm', 'Paige Shelton', 'A mystery novel with intense suspense and adventure, set in an unpredictable and stormy environment.', 21, 'Thriller', 'images/perfect-storm.jpg', '2025-02-22 02:16:24'),
(25, 'eruption', 'Eruption', 'Michael Crichton and James Patterson', 'A thrilling disaster novel combining science, suspense, and fast-paced storytelling.', 24, 'Thriller', 'images/eruption.jpg', '2025-02-22 02:16:24'),
(26, 'the-shining', 'The Shining', 'Stephen King', 'A psychological horror novel about a family’s terrifying stay at the haunted Overlook Hotel.', 20, 'Horror', 'images/the-shining.jpg', '2025-02-22 02:16:24'),
(27, 'it', 'IT', 'Stephen King', 'A chilling story about a shape-shifting entity that terrorizes the children of Derry, Maine.', 24, 'Horror', 'images/it.jpg', '2025-02-22 02:16:24'),
(28, 'dracula', 'Dracula', 'Bram Stoker', 'The classic Gothic horror novel that introduced Count Dracula and the legend of vampires.', 15, 'Horror', 'images/dracula.jpg', '2025-02-22 02:16:24'),
(29, 'the-exorcist', 'The Exorcist', 'William Peter Blatty', 'A terrifying tale of demonic possession and the battle between faith and evil.', 20, 'Horror', 'images/the-exorcist.jpg', '2025-02-22 02:16:24'),
(30, 'ghost-story', 'Ghost Story', 'Peter Straub', 'A supernatural thriller about four old men who are haunted by a horrifying secret from their past.', 19, 'Horror', 'images/ghost-story.jpg', '2025-02-22 02:16:24'),
(31, 'the-light-fantastic', 'The Light Fantastic', 'Terry Pratchett', 'The second book in the Discworld series, following Rincewind and Twoflower on a magical adventure.', 20, 'Fantasy', 'images/light-fantastic-cover.jpg', '2025-02-22 15:10:36'),
(32, 'solo-leveling', 'Solo Leveling', 'Chugong', 'A weak hunter gets a mysterious system that makes him the strongest.', 16, 'Light Novel', 'images/solo_leveling.jpg', '2025-02-25 20:12:28'),
(33, 'spy-x-family', 'Spy x Family', 'Tatsuya Endo', 'A spy, an assassin, and a telepath form a fake family.', 17, 'Manga', 'images/spy_x_family.jpg', '2025-02-25 20:12:28'),
(34, 'dan-da-dan', 'Dan Da Dan', 'Yukinobu Tatsu', 'A mix of supernatural, sci-fi, and horror with a comedic twist.', 25, 'Manga', 'images/dan_da_dan.jpg', '2025-02-25 20:12:28'),
(35, 'jujutsu-kaisen', 'Jujutsu Kaisen', 'Gege Akutami', 'A high school student gains cursed powers and fights dark spirits.', 15, 'Manga', 'images/jujutsu_kaisen.jpg', '2025-02-25 20:12:28'),
(36, 'blue-lock', 'Blue Lock', 'Muneyuki Kaneshiro', 'An intense football training program to create the best striker.', 16, 'Manga', 'images/blue_lock.jpg', '2025-02-25 20:12:28'),
(37, 'omniscient-readers-viewpoint', 'Omniscient Reader’s Viewpoint', 'Sing-Shong', 'A reader of a web novel finds himself inside the story.', 23, 'Light Novel', 'images/omniscient_readers_viewpoint.jpg', '2025-02-25 20:12:28'),
(38, 'one-piece', 'One Piece', 'Eiichiro Oda', 'A story about pirates in search of the ultimate treasure, One Piece.', 19, 'Manga', 'images/one-piece.jpg', '2025-02-25 20:12:28'),
(39, 'naruto', 'Naruto', 'Masashi Kishimoto', 'A young ninja strives to become the Hokage while overcoming challenges.', 23, 'Manga', 'images/naruto.jpg', '2025-02-25 20:12:28'),
(40, 'bleach', 'Bleach', 'Tite Kubo', 'A teenager gains Soul Reaper powers and fights against evil spirits.', 22, 'Manga', 'images/bleach.jpg', '2025-02-25 20:12:28'),
(41, 'attack-on-titan', 'Attack on Titan', 'Hajime Isayama', 'Humanity fights for survival against giant humanoid Titans.', 15, 'Manga', 'images/attack-on-titan.jpg', '2025-02-25 20:12:28'),
(42, 'demon-slayer', 'Demon Slayer', 'Koyoharu Gotouge', 'A young swordsman battles demons to save his sister and avenge his family.', 17, 'Manga', 'images/demon-slayer.jpg', '2025-02-25 20:12:28'),
(43, 'death-note', 'Death Note', 'Tsugumi Ohba', 'A student discovers a notebook that grants the power to kill anyone.', 25, 'Manga', 'images/death-note.jpg', '2025-02-25 20:12:28'),
(44, 'dragon-ball', 'Dragon Ball', 'Akira Toriyama', 'A martial artist embarks on adventures to find mystical Dragon Balls.', 15, 'Manga', 'images/dragon-ball.jpg', '2025-02-25 20:12:28'),
(46, 'the-legend-of-the-northern-blade', 'The Legend of the Northern Blade', 'Woo-Gak', 'A martial artist seeks revenge and restores his fallen sect in a world of deadly warriors.', 19, 'Light Novel', 'images/the-legend-of-the-northern-blade.jpg', '2025-02-25 20:38:51'),
(50, 'the-silent-patient', 'The Silent Patient', 'Alex Michaelides', 'A psychological thriller about a woman’s act of violence against her husband—and the therapist obsessed with uncovering her motive.', 23, 'Thriller', 'images/silent_patient.jpg', '2025-03-05 18:05:20'),
(51, 'lock-every-door', 'Lock Every Door', 'Riley Sager', 'A suspenseful novel about a woman who takes a job as an apartment sitter, only to discover the building’s dark and deadly secrets.', 24, 'Thriller', 'images/lock_every_door.jpg', '2025-03-05 18:05:20'),
(53, 'dtrfyugvh', 'dtrfyugvh', 'lkjidsrdfgu', 'guxcghjhcvhbjkjkhjhfxdfydfgjfcvhbjkhxfdtfyugjvbjk', 20, 'Light Novel', 'images/the-world-after-the-fall.jpg', '2025-03-17 19:34:19');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `message` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `username`, `email`, `mobile`, `rating`, `message`, `date`) VALUES
(1, 1, 'wesly', 'weslywesly37@gmail.com', '8940461802', 5, 'good', '2025-02-28 13:20:38');

-- --------------------------------------------------------

--
-- Table structure for table `rentals`
--

CREATE TABLE `rentals` (
  `rental_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `rental_date` date NOT NULL DEFAULT current_timestamp(),
  `return_date` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `approval_status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `rental_status` enum('on rented','returned','overdue','pending') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rentals`
--

INSERT INTO `rentals` (`rental_id`, `user_id`, `book_id`, `rental_date`, `return_date`, `address`, `approval_status`, `rental_status`) VALUES
(28, 1, 22, '2025-03-17', '2025-03-24', 'tirunelveli', 'approved', 'on rented'),
(29, 2, 11, '2025-03-17', '2025-03-24', 'tirunelveli', 'pending', 'pending'),
(31, 1, 40, '2025-03-20', '2025-03-27', 'thirunelveli', 'pending', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `phone_number` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `created_at`, `role`, `phone_number`) VALUES
(1, 'wesly', 'weslywesly37@gmail.com', '$2y$10$T1JgKUKhzpigvVshws75z.cfgPfBSCSaiyqfwZviPp1RwNGi3BajS', '2025-01-14 08:00:42', 'user', 8940461802),
(2, 'john', 'weslywesly57@gmail.com', '$2y$10$D9y.L9PMgN7CwSz8C4vuNeNOr8YPgiZT/3GLr2Yya5NoLxquzE2Ki', '2025-01-14 08:05:13', 'user', 8940461803),
(4, 'admin', 'admin@gmail.com', '$2y$10$GgykwJL7uGcKzKGxrKlwCO4jNRcIYTqbdJEwFg/Y4SFqhMa3nAcXu', '2025-03-12 19:04:31', 'admin', 8940461804);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD UNIQUE KEY `key_slug` (`key_slug`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rentals`
--
ALTER TABLE `rentals`
  ADD PRIMARY KEY (`rental_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `phone_number` (`phone_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rentals`
--
ALTER TABLE `rentals`
  MODIFY `rental_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `rentals`
--
ALTER TABLE `rentals`
  ADD CONSTRAINT `rentals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rentals_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
