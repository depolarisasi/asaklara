-- =====================================================
-- ASAK Agency CMS — Database Schema
-- Import file ini via phpMyAdmin di: lucky.jagoanhosting.id
-- Database: asakdigi_comproweb
-- Generated: 2026-04-12
-- =====================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- Users (Laravel default)
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Migrations tracking
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text,
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Team Members
CREATE TABLE IF NOT EXISTS `team_members` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `order` int NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Services
CREATE TABLE IF NOT EXISTS `services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `order` int NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `services_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Service Features
CREATE TABLE IF NOT EXISTS `service_features` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `service_id` bigint unsigned NOT NULL,
  `feature` varchar(255) NOT NULL,
  `order` int NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `service_features_service_id_foreign` (`service_id`),
  CONSTRAINT `service_features_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Process Steps
CREATE TABLE IF NOT EXISTS `process_steps` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `step_number` varchar(5) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `order` int NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Portfolios
CREATE TABLE IF NOT EXISTS `portfolios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `client` varchar(255) NOT NULL,
  `year` varchar(4) NOT NULL,
  `category` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `order` int NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `portfolios_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Contact Submissions
CREATE TABLE IF NOT EXISTS `contact_submissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- SEED: Admin User
-- Password: asak2024!
-- =====================================================
INSERT IGNORE INTO `users` (`name`, `email`, `password`, `created_at`, `updated_at`)
VALUES ('ASAK Admin', 'admin@asak.agency', '$2y$12$YDqDH8F2GbFoXpFiE2L0XuHoLQ0KKgEilqSGLpE1LLvNDNVzF1mGq', NOW(), NOW());

-- =====================================================
-- SEED: Settings
-- =====================================================
INSERT IGNORE INTO `settings` (`key`, `value`, `group`, `created_at`, `updated_at`) VALUES
('hero.badge_text', 'The Anti-Chaos Agency', 'hero', NOW(), NOW()),
('hero.headline', 'Done Right.', 'hero', NOW(), NOW()),
('hero.headline_accent', 'Done On Time.', 'hero', NOW(), NOW()),
('hero.subheadline', 'We are the anti-chaos agency. We bridge the gap between creative disruption and operational excellence.', 'hero', NOW(), NOW()),
('hero.cta_primary', 'Start a Project', 'hero', NOW(), NOW()),
('hero.cta_secondary', 'View Our Work', 'hero', NOW(), NOW()),
('stats.projects', '150+', 'stats', NOW(), NOW()),
('stats.clients', '50+', 'stats', NOW(), NOW()),
('stats.experience', '5+', 'stats', NOW(), NOW()),
('stats.awards', '15+', 'stats', NOW(), NOW()),
('about.hero_title', 'The Anti-Chaos Agency', 'about', NOW(), NOW()),
('about.hero_subtitle', 'Born from the high-volume demands of the global gig economy and refined for corporate scalability, we bridge the gap between creative disruption and operational excellence.', 'about', NOW(), NOW()),
('about.philosophy', '"Asak" Means Mature. Ready.', 'about', NOW(), NOW()),
('about.story_text_1', 'It represents the final state of perfection after a rigorous process. In the digital world, "Asak" is our Definition of Done.', 'about', NOW(), NOW()),
('about.story_text_2', 'We believe that great ideas are worthless if they remain "raw" or poorly executed. At asak digital, we bridge the gap between abstract concepts and concrete reality.', 'about', NOW(), NOW()),
('about.story_text_3', 'We don\'t just deliver projects; we deliver maturity—fully tested, fully optimized, and ready for market impact.', 'about', NOW(), NOW()),
('contact.email', 'hello@asak.agency', 'contact', NOW(), NOW()),
('contact.website', 'www.asak.agency', 'contact', NOW(), NOW()),
('contact.address', 'Jakarta, Indonesia — International Projects Worldwide', 'contact', NOW(), NOW()),
('contact.response_time', 'Zero-Delay Protocol Active', 'contact', NOW(), NOW()),
('social.instagram', '#', 'social', NOW(), NOW()),
('social.twitter', '#', 'social', NOW(), NOW()),
('social.linkedin', '#', 'social', NOW(), NOW());

-- =====================================================
-- SEED: Team Members
-- =====================================================
INSERT IGNORE INTO `team_members` (`name`, `role`, `image`, `order`, `active`, `created_at`, `updated_at`) VALUES
('Juliana Silva', 'Chief Executive Officer (CEO)', 'https://picsum.photos/seed/juliana-silva/200/200', 1, 1, NOW(), NOW()),
('Aaron Loeb', 'Chief Operating Officer (COO)', 'https://picsum.photos/seed/aaron-loeb/200/200', 2, 1, NOW(), NOW()),
('Olivia Wilson', 'Director', 'https://picsum.photos/seed/olivia-wilson/200/200', 3, 1, NOW(), NOW()),
('Neil Tran', 'Head Manager', 'https://picsum.photos/seed/neil-tran/200/200', 4, 1, NOW(), NOW());

-- =====================================================
-- SEED: Services
-- =====================================================
INSERT IGNORE INTO `services` (`title`, `slug`, `description`, `image`, `order`, `active`, `created_at`, `updated_at`) VALUES
('Brand Engineering', 'brand-engineering', 'Identity, UI/UX, Visual System, Graphic & Video. We don\'t just create brands—we engineer them for scalability and market dominance.', 'https://picsum.photos/seed/brand-engineering/600/600', 1, 1, NOW(), NOW()),
('Tech Development', 'tech-development', 'Web, Apps, & Custom Software. We build scalable digital solutions that perform flawlessly.', 'https://picsum.photos/seed/tech-development/600/600', 2, 1, NOW(), NOW()),
('Growth Hacking', 'growth-hacking', 'Data-Driven Marketing & SEO. Strategic campaigns with full transparency on every metric.', 'https://picsum.photos/seed/growth-hacking/600/600', 3, 1, NOW(), NOW()),
('Photo & Videography', 'photo-videography', 'Professional visual content with global standards. From product shots to corporate videos.', 'https://picsum.photos/seed/photo-videography/600/600', 4, 1, NOW(), NOW());

-- Service Features (insert after services)
INSERT IGNORE INTO `service_features` (`service_id`, `feature`, `order`, `created_at`, `updated_at`)
SELECT s.id, f.feature, f.ord, NOW(), NOW() FROM services s
JOIN (
  SELECT 'brand-engineering' as slug, 'Brand identity systems' as feature, 1 as ord
  UNION SELECT 'brand-engineering', 'UI/UX design', 2
  UNION SELECT 'brand-engineering', 'Visual system development', 3
  UNION SELECT 'brand-engineering', 'Logo & brand guidelines', 4
  UNION SELECT 'brand-engineering', 'Marketing collateral', 5
  UNION SELECT 'brand-engineering', 'Motion graphics', 6
  UNION SELECT 'tech-development', 'Custom web applications', 1
  UNION SELECT 'tech-development', 'Mobile app development', 2
  UNION SELECT 'tech-development', 'E-commerce platforms', 3
  UNION SELECT 'tech-development', 'API development', 4
  UNION SELECT 'tech-development', 'System integration', 5
  UNION SELECT 'tech-development', 'Performance optimization', 6
  UNION SELECT 'growth-hacking', 'SEO optimization', 1
  UNION SELECT 'growth-hacking', 'Paid advertising (PPC)', 2
  UNION SELECT 'growth-hacking', 'Social media marketing', 3
  UNION SELECT 'growth-hacking', 'Content strategy', 4
  UNION SELECT 'growth-hacking', 'Analytics & reporting', 5
  UNION SELECT 'growth-hacking', 'Conversion optimization', 6
  UNION SELECT 'photo-videography', 'Product photography', 1
  UNION SELECT 'photo-videography', 'Corporate videos', 2
  UNION SELECT 'photo-videography', 'Event coverage', 3
  UNION SELECT 'photo-videography', 'Brand storytelling', 4
  UNION SELECT 'photo-videography', 'Social media content', 5
  UNION SELECT 'photo-videography', 'Drone videography', 6
) f ON s.slug = f.slug;

-- =====================================================
-- SEED: Process Steps
-- =====================================================
INSERT IGNORE INTO `process_steps` (`step_number`, `title`, `description`, `order`, `created_at`, `updated_at`) VALUES
('01', 'Discovery', 'We learn about your business, goals, and target audience to understand your unique needs.', 1, NOW(), NOW()),
('02', 'Strategy', 'We develop a comprehensive strategy tailored to achieve your objectives effectively.', 2, NOW(), NOW()),
('03', 'Creation', 'Our creative team brings the strategy to life with exceptional design and development.', 3, NOW(), NOW()),
('04', 'Launch', 'We deliver the final product and provide support for a successful launch.', 4, NOW(), NOW());

-- =====================================================
-- SEED: Portfolio
-- =====================================================
INSERT IGNORE INTO `portfolios` (`title`, `slug`, `description`, `client`, `year`, `category`, `image`, `featured`, `order`, `active`, `created_at`, `updated_at`) VALUES
('TechFlow Rebrand', 'techflow-rebrand', 'Complete visual identity redesign for a leading tech startup, including logo, brand guidelines, and marketing collateral.', 'TechFlow Inc.', '2024', 'Graphic Design', 'https://picsum.photos/seed/techflow-brand/1200/600', 1, 1, 1, NOW(), NOW()),
('Urban Eats Platform', 'urban-eats-platform', 'Modern e-commerce platform for a food delivery service with seamless ordering experience.', 'Urban Eats', '2024', 'Web Design', 'https://picsum.photos/seed/urban-eats/800/600', 1, 2, 1, NOW(), NOW()),
('Horizon Corporate Film', 'horizon-corporate-film', 'Cinematic brand story video showcasing company culture and values for investor relations.', 'Horizon Group', '2024', 'Photo & Video', 'https://picsum.photos/seed/horizon-film/800/600', 1, 3, 1, NOW(), NOW()),
('GreenLife Campaign', 'greenlife-campaign', 'Integrated digital marketing campaign driving 300% increase in engagement for sustainable living brand.', 'GreenLife Co.', '2023', 'Digital Marketing', 'https://picsum.photos/seed/greenlife-campaign/800/600', 0, 4, 1, NOW(), NOW()),
('Artisan Coffee Website', 'artisan-coffee-website', 'Elegant website design with online ordering system for premium coffee roaster.', 'Artisan Coffee', '2023', 'Web Design', 'https://picsum.photos/seed/artisan-coffee/800/600', 0, 5, 1, NOW(), NOW()),
('Fashion Forward Lookbook', 'fashion-forward-lookbook', 'High-fashion photography and video campaign for seasonal collection launch.', 'Fashion Forward', '2023', 'Photo & Video', 'https://picsum.photos/seed/fashion-lookbook/800/600', 0, 6, 1, NOW(), NOW()),
('FinTech App Identity', 'fintech-app-identity', 'Modern brand identity for innovative financial technology application targeting millennials.', 'PaySmart', '2023', 'Graphic Design', 'https://picsum.photos/seed/fintech-app/800/600', 0, 7, 1, NOW(), NOW()),
('Travel Social Strategy', 'travel-social-strategy', 'Social media strategy and content creation for luxury travel agency reaching global audience.', 'Wanderlust Travel', '2023', 'Digital Marketing', 'https://picsum.photos/seed/travel-social/800/600', 0, 8, 1, NOW(), NOW());

-- Migrations tracking
INSERT IGNORE INTO `migrations` (`migration`, `batch`) VALUES
('0001_01_01_000000_create_users_table', 1),
('0001_01_01_000001_create_cache_table', 1),
('0001_01_01_000002_create_jobs_table', 1),
('2026_04_12_013544_create_settings_table', 1),
('2026_04_12_013545_create_team_members_table', 1),
('2026_04_12_013546_create_services_table', 1),
('2026_04_12_013547_create_service_features_table', 1),
('2026_04_12_013548_create_process_steps_table', 1),
('2026_04_12_013549_create_portfolios_table', 1),
('2026_04_12_013550_create_contact_submissions_table', 1);

SET FOREIGN_KEY_CHECKS = 1;
