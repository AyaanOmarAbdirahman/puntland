-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2026 at 05:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `puntland_tourism`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_code` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tour_package_id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `current_location` varchar(255) DEFAULT NULL,
  `emergency_contact` varchar(255) DEFAULT NULL,
  `travel_date` date NOT NULL,
  `number_of_guests` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `special_requests` text DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `payment_status` varchar(255) NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `booking_code`, `user_id`, `tour_package_id`, `full_name`, `email`, `phone`, `current_location`, `emergency_contact`, `travel_date`, `number_of_guests`, `total_price`, `special_requests`, `rejection_reason`, `status`, `payment_status`, `created_at`, `updated_at`) VALUES
(1, 'PNT-XRVKZB', 2, 1, 'Jamaal Hassan', 'tourist@example.com', '+252 90 712 3456', 'Garowe, Puntland', NULL, '2026-09-19', 2, 240.00, 'Vegetarian meal options required during the tour.', NULL, 'confirmed', 'paid', '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(2, 'PNT-LSUIXC', 3, 2, 'mahamuud', 'mahmuud09@gmail.com', '37644792302', 'Garoowe', NULL, '2026-09-12', 2, 900.00, 'i like', NULL, 'cancelled', 'paid', '2026-09-09 10:20:08', '2026-09-12 11:18:23');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Coastal & Beaches', 'coastal-beaches', 'fa-umbrella-beach', 'Turquoise ocean water, white sand beaches, marine safari, and coastal ports.', '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(2, 'Historical Forts & Castles', 'historical-forts', 'fa-fort-awesome', 'Centuries-old stone fortresses, Dervish castles, and ancient frankincense trading ports.', '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(3, 'Mountain Ranges & Valleys', 'mountain-ranges', 'fa-mountain', 'Cool mountain elevations, natural waterfalls, frankincense forests, and hiking canyons.', '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(4, 'Modern Cities & Cultural Heritage', 'modern-cities', 'fa-city', 'Vibrant urban centers, traditional markets, state monuments, and Somali cuisine.', '2026-09-09 10:13:02', '2026-09-09 10:13:02');

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE `destinations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `featured_image` varchar(255) NOT NULL,
  `gallery` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gallery`)),
  `entry_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `rating` decimal(3,2) NOT NULL DEFAULT 4.80,
  `is_featured` tinyint(1) NOT NULL DEFAULT 1,
  `best_season` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`id`, `category_id`, `title`, `slug`, `region`, `city`, `description`, `latitude`, `longitude`, `featured_image`, `gallery`, `entry_fee`, `rating`, `is_featured`, `best_season`, `created_at`, `updated_at`) VALUES
(1, 4, 'Garowe Capital City Center', 'garowe-capital-city-center', 'Nugaal', 'Garowe', 'Caasimadda dawlad goboleedka Puntland, xarunta nabadda, dawladnimada iyo maamulka. Waxay caan ku tahay bilicda, suuqyada dhaqanka iyo cuntooyinka asalka ah.', 8.4064000, 48.4844000, 'images/cities/garowe.jpg', NULL, 15.00, 4.90, 1, 'All Year', '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(2, 1, 'Raas_casyr & Gacanka Badda', 'raas-casyr-gacanka-badda', 'Gardafuul', 'Raas_casyr', 'Halka ugu bariisan qaaradda Afrika, halkaas oo ay isaga darsamaan labada badood ee Badda Cas iyo Badweynta Hindiya. Waa goob taariikhi ah oo dalxiis u roon.', 11.8333000, 51.2667000, 'images/cities/raas-casyr.jpg', NULL, 30.00, 4.98, 1, 'November - March', '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(3, 3, 'Ceerigaabo iyo Buuraha Daallo', 'ceerigaabo-iyo-buuraha-daallo', 'Sanaag', 'Ceerigaabo', 'Caasimadda buuraleyda ee gobolka Sanaag, waxay caan ku tahay cimilo aad u qabow, dhirta baxa xilliga roobabka, cagaarka iyo keymaha waawayn ee Daallo.', 10.6190000, 47.3680000, 'images/cities/ceerigaabo.jpg', NULL, 20.00, 4.93, 1, 'September - May', '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(4, 3, 'Buuraha Calmadow iyo Biyo Dhaca', 'buuraha-calmadow-iyo-biyo-dhaca', 'Sanaag', 'Calmadow', 'Buuraha ugu dhaadheer uguna quruxda badan Soomaaliya, halkaas oo aad ugu riyaaqi karto biyo dhac (waterfalls) cajiib ah, cagaar, iyo shimbiro kala duwan.', 10.7431000, 47.2412000, 'images/cities/calmadow.jpg', NULL, 40.00, 4.99, 1, 'All Year', '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(5, 1, 'Xeebta Taariikhiga ah ee Laas_qoray', 'xeebta-taariikhiga-ah-ee-laas-qoray', 'Sanaag', 'Laas_qoray', 'Magaalo xeebeed caan ku ah taariikh fog iyo kalluumaysiga. Waxay xuddun u ahayd ganacsiga badda oo hodan ku ah kheyraadka kalluunka tuunaha.', 11.1600000, 48.1970000, 'images/cities/laas-qoray.jpg', NULL, 15.00, 4.88, 1, 'October - April', '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(6, 2, 'Qandala, Qalcaddaha iyo Beeyada', 'qandala-qalcaddaha-iyo-beeyada', 'Bari', 'Qandala', 'Dhul isku dara badda cagaaran, buuraha, iyo taariikhda. Qandala waxay caan ku tahay dhismayaasha dhagaxa ah, doonyaha la sameeyo iyo buuraha laga guro luubaanta iyo beeyada.', 11.4719000, 49.8728000, 'images/cities/qandala.jpg', NULL, 25.00, 4.95, 1, 'All Year', '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(7, 1, 'Boosaaso Commercial Hub & Beach', 'boosaaso-commercial-hub-beach', 'Bari', 'Boosaaso', 'Isha dhaqaalaha Puntland oo idil. Magaalo deked leh oo leh suuqyo waawayn, xeebo qurxoon, iyo goobo muhiim u ah dalxiiska.', 11.2842000, 49.1816000, 'images/cities/boosaaso.jpg', NULL, 20.00, 4.92, 1, 'October - March', '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(8, 2, 'Eyl Daawad & Qalcadda Taariikhiga', 'eyl-daawad-qalcadda-taariikhiga', 'Nugaal', 'Eyl', 'Qalcado taariikhi ah oo xasuus leh xilligii Daraawiishta. Eyl sidoo kale waxay leedahay dooxyo iyo xeeb cajiib ah oo lagu dalxiiso.', 7.9803000, 49.8164000, 'images/cities/eyl.jpg', NULL, 25.00, 4.96, 1, 'All Year', '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(9, 4, 'Gaalkacyo Xuddunta Mudug', 'gaalkacyo-xuddunta-mudug', 'Mudug', 'Gaalkacyo', 'Magaalo u dhaxaysa gobolada waqooyi iyo koonfur, caan ku ah suuqyada xoolaha, ganacsiga isku-gudbinta iyo hiddaha dhaqanka miyiga.', 6.7697000, 47.4308000, 'images/cities/gaalkacyo.jpg', NULL, 10.00, 4.82, 1, 'All Year', '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(10, 4, 'Qardho Xarunta Dhaqanka', 'qardho-xarunta-dhaqanka', 'Karkaar', 'Qardho', 'Fadhiga boqortooyada iyo dhaqanka faca-weyn. Waxay caan ku tahay geedaha timirta, xoolaha iyo cimilo macaan.', 9.5042000, 49.0833000, 'images/cities/qardho.jpg', NULL, 10.00, 4.85, 1, 'All Year', '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(11, 2, 'Qalcadda Taleex (Silsilad)', 'qalcadda-taleex-silsilad', 'Sool', 'Taleex', 'Qalcadda ugu wayn ee taariikhiga ah taas oo fariisin u ahayd halgankii Daraawiishta. Waa mid ka mid ah astaamaha ugu waaweyn ee halganka Soomaaliyeed.', 9.1450000, 48.4210000, 'images/cities/taleex.jpg', NULL, 20.00, 4.97, 1, 'October - April', '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(12, 3, 'Badhaniyo Togagga Biyaha', 'badhaniyo-togagga-biyaha', 'Sanaag', 'Badhan', 'Magaalo si xawli ah ku koreysa oo ku dhax taal dooxooyin cagaaran, biyo joogto ah, iyo beero wax soo saar badan leh.', 10.7130000, 48.3370000, 'images/cities/badhan.jpg', NULL, 15.00, 4.80, 1, 'All Year', '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(13, 4, 'Galdogob iyo Daqaanka', 'galdogob-iyo-daqaanka', 'Mudug', 'Galdogob', 'Magaalo si degdeg ah u koreysa oo ku taal xudduudka, caan ku ah ganacsiga xoolaha, iyo nabadgalyo. Waxay leedahay muuqaalo degan iyo dhaqan aslan.', 7.0225000, 46.9950000, 'images/cities/galdogob.jpg', NULL, 10.00, 4.75, 1, 'All Year', '2026-09-09 10:13:02', '2026-09-09 10:13:02');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_01_000000_create_tourism_tables', 1),
(5, '2026_01_01_000003_add_customer_details_and_rejection_to_bookings_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'booking',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `is_read`, `created_at`, `updated_at`) VALUES
(1, NULL, 'New Tour Package Booking', 'mahamuud booked Raas_casyr Expedition for 2 guest(s). Location: Garoowe, Phone: 37644792302. Code: PNT-LSUIXC', 'booking', 0, '2026-09-09 10:20:08', '2026-09-09 10:20:08'),
(2, 3, 'Booking #PNT-LSUIXC Status Changed', 'Your booking status is now Pending', 'booking', 0, '2026-09-09 10:20:44', '2026-09-09 10:20:44'),
(3, 3, 'Booking #PNT-LSUIXC Status Changed', 'Your booking status is now Confirmed', 'booking', 0, '2026-09-09 10:21:20', '2026-09-09 10:21:20');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `destination_id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saved_places`
--

CREATE TABLE `saved_places` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `destination_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('4HOqSWRADwfjyp23rdn2uKN9NFpseNcCK4iFwwuO', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSFBEUmkyZEpDVWZ4SWp6RURvbWdCYWJhT3pBOWFKcjEzamtpSVlCZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9sb2NhbGhvc3QvdG91cmlzbS9wdWJsaWMiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1791022461),
('lZd0TVuAJNVClRwF9WJDzz6jXkHwK8RMbDvte0RW', 3, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVzZ2d3JSWXBscG5xZENuNkx4Z3lZSjg5MFFWSHNFcE1kdXJmWWdDWSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTg6Imh0dHA6Ly9sb2NhbGhvc3QvdG91cmlzbS9wdWJsaWMvYXBpL3JlYWx0aW1lL25vdGlmaWNhdGlvbnMiO3M6NToicm91dGUiO3M6MjY6ImFwaS5yZWFsdGltZS5ub3RpZmljYXRpb25zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mzt9', 1791023526),
('uDIoNhtmL3mBUdpnXdTn3evDNnJM2lEaH5P5R9VM', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTjFMNDhxSTREV2pIUnRHRUN2cUd6b2MyVnhjaHlVT1RsTjJ1cmZpViI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNzoiaHR0cDovL2xvY2FsaG9zdC90b3VyaXNtL3B1YmxpYy9hZG1pbiI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM3OiJodHRwOi8vbG9jYWxob3N0L3RvdXJpc20vcHVibGljL2FkbWluIjtzOjU6InJvdXRlIjtzOjE1OiJhZG1pbi5kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1791040999),
('YPh5XZJF76TbSs0Tg8VDotlkc6FjrBunrFiwF5Ek', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZmF0NHdWTDZXWUFBRGh2cFEzYTlYQklKblB5VTZicmhpOFJvNHoyViI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNzoiaHR0cDovL2xvY2FsaG9zdC90b3VyaXNtL3B1YmxpYy9hZG1pbiI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vbG9jYWxob3N0L3RvdXJpc20vcHVibGljIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1791041027);

-- --------------------------------------------------------

--
-- Table structure for table `tour_packages`
--

CREATE TABLE `tour_packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `destination_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `duration_days` int(11) NOT NULL,
  `price_per_person` decimal(10,2) NOT NULL,
  `max_capacity` int(11) NOT NULL DEFAULT 20,
  `included_services` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`included_services`)),
  `itinerary` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`itinerary`)),
  `start_date` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tour_packages`
--

INSERT INTO `tour_packages` (`id`, `destination_id`, `title`, `slug`, `duration_days`, `price_per_person`, `max_capacity`, `included_services`, `itinerary`, `start_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Garowe City Tour', 'garowe-city-tour', 2, 120.00, 20, '[\"Hotel\",\"Transport\",\"City Guide\",\"Lunch\"]', NULL, '2026-09-14', 'active', '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(2, 2, 'Raas_casyr Expedition', 'raas-casyr-expedition', 4, 450.00, 10, '[\"Camping\",\"4x4 Transport\",\"Boat ride\",\"Meals\"]', NULL, '2026-09-14', 'active', '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(3, 3, 'Ceerigaabo Nature Trail', 'ceerigaabo-nature-trail', 3, 280.00, 15, '[\"Lodge\",\"Tour Guide\",\"Hiking\",\"Breakfast\"]', NULL, '2026-09-14', 'active', '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(4, 4, 'Calmadow Hiking Adventure', 'calmadow-hiking-adventure', 5, 550.00, 8, '[\"Tent Camping\",\"Guide\",\"Trekking gear\",\"All meals\"]', NULL, '2026-09-14', 'active', '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(5, 5, 'Laas_qoray Fishery & Beach Tour', 'laas-qoray-fishery-beach-tour', 3, 210.00, 12, '[\"Guesthouse\",\"Fishing Trip\",\"Seafood BBQ\",\"Transport\"]', NULL, '2026-09-14', 'active', '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(6, 6, 'Qandala Heritage Trip', 'qandala-heritage-trip', 3, 320.00, 12, '[\"Hotel\",\"Frankincense Tour\",\"Boat Ride\",\"Meals\"]', NULL, '2026-09-14', 'active', '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(7, 7, 'Boosaaso Weekend Getaway', 'boosaaso-weekend-getaway', 2, 180.00, 25, '[\"Resort\",\"Transport\",\"City Tour\",\"Dinner\"]', NULL, '2026-09-14', 'active', '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(8, 8, 'Eyl Historic Safari', 'eyl-historic-safari', 3, 300.00, 15, '[\"Lodge\",\"Fort Guide\",\"Beach access\",\"Meals\"]', NULL, '2026-09-14', 'active', '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(9, 9, 'Mudug Nomadic Experience', 'mudug-nomadic-experience', 2, 140.00, 20, '[\"Hotel\",\"Transport\",\"Market Tour\",\"Lunch\"]', NULL, '2026-09-14', 'active', '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(10, 10, 'Qardho Royal Heritage', 'qardho-royal-heritage', 2, 150.00, 15, '[\"Hotel\",\"Cultural Tour\",\"Meals\"]', NULL, '2026-09-14', 'active', '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(11, 11, 'Taleex Dervish History Tour', 'taleex-dervish-history-tour', 3, 260.00, 10, '[\"Guesthouse\",\"History Guide\",\"Transport\",\"Meals\"]', NULL, '2026-09-14', 'active', '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(12, 12, 'Badhan Valley Tour', 'badhan-valley-tour', 2, 170.00, 12, '[\"Hotel\",\"Valley Tour\",\"Transport\",\"Meals\"]', NULL, '2026-09-14', 'active', '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(13, 13, 'Galdogob Community Visit', 'galdogob-community-visit', 2, 130.00, 15, '[\"Hotel\",\"City guide\",\"Meals\",\"Transport\"]', NULL, '2026-09-14', 'active', '2026-09-09 10:13:02', '2026-09-09 10:13:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'tourist',
  `phone` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `phone`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Puntland Tourism Authority Admin', 'admin@tourism.gov.so', 'admin', '+252 90 779 0001', 'https://ui-avatars.com/api/?name=Puntland+Admin&background=0a192f&color=fff', NULL, '$2y$12$t4IFpSwEheqfEcOYPf.0q.yNrbx2oONFKoPxV9GzPSuo16fuaKJyS', NULL, '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(2, 'Jamaal Hassan', 'tourist@example.com', 'tourist', '+252 90 712 3456', 'https://ui-avatars.com/api/?name=Jamaal+Hassan&background=00b4d8&color=fff', NULL, '$2y$12$WN9kfvHHu.w3Yrp6UiL4UuaVmQZZjNqpfnihjiVK5IT1I3s8vIY/G', NULL, '2026-09-09 10:13:02', '2026-09-09 10:13:02'),
(3, 'mahamuud', 'mahmuud09@gmail.com', 'tourist', '37644792302', 'https://ui-avatars.com/api/?name=mahamuud&background=00b4d8&color=fff', NULL, '$2y$12$rIa..Iq9qjEdlXGmrs57Jummmp3.u5e5jDx0zGL5kPNxp5QVuyQB.', NULL, '2026-09-09 10:16:51', '2026-09-09 10:16:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bookings_booking_code_unique` (`booking_code`),
  ADD KEY `bookings_user_id_foreign` (`user_id`),
  ADD KEY `bookings_tour_package_id_foreign` (`tour_package_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `destinations_slug_unique` (`slug`),
  ADD KEY `destinations_category_id_foreign` (`category_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_destination_id_foreign` (`destination_id`);

--
-- Indexes for table `saved_places`
--
ALTER TABLE `saved_places`
  ADD PRIMARY KEY (`id`),
  ADD KEY `saved_places_user_id_foreign` (`user_id`),
  ADD KEY `saved_places_destination_id_foreign` (`destination_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tour_packages`
--
ALTER TABLE `tour_packages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tour_packages_slug_unique` (`slug`),
  ADD KEY `tour_packages_destination_id_foreign` (`destination_id`);

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
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saved_places`
--
ALTER TABLE `saved_places`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tour_packages`
--
ALTER TABLE `tour_packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_tour_package_id_foreign` FOREIGN KEY (`tour_package_id`) REFERENCES `tour_packages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `destinations`
--
ALTER TABLE `destinations`
  ADD CONSTRAINT `destinations_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_destination_id_foreign` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `saved_places`
--
ALTER TABLE `saved_places`
  ADD CONSTRAINT `saved_places_destination_id_foreign` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `saved_places_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tour_packages`
--
ALTER TABLE `tour_packages`
  ADD CONSTRAINT `tour_packages_destination_id_foreign` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
