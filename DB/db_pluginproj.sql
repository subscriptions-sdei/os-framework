-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 04, 2014 at 11:02 AM
-- Server version: 5.5.36
-- PHP Version: 5.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_pluginproj`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `email` varchar(55) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(55) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '''0'' => Inactive, ''1'' => ''Active''',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=>''deleted'',0=>''not deleted''',
  `welcome` text NOT NULL,
  `random_key` varchar(200) DEFAULT NULL,
  `admin_role_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `admin_roles`
--

CREATE TABLE IF NOT EXISTS `admin_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL,
  `role_description` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=>inactive, 1=>''active''',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=>deleted, 0 =>Not deleted',
  `created` date NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `basic_settings`
--

CREATE TABLE IF NOT EXISTS `basic_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logo` varchar(255) NOT NULL,
  `site_name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `category` varchar(55) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL COMMENT '''0'' => Inactive, ''1'' => ''Active''',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=>''deleted'',0=>''not deleted''',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category` (`category`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `address_2` varchar(255) NOT NULL,
  `country_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  `zip` int(11) NOT NULL,
  `phone_no` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0=>inactive, 1=>''active''',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=>''deleted'',0=>''not deleted''',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `company_subscriptions`
--

CREATE TABLE IF NOT EXISTS `company_subscriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `subscription_id` int(11) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=>''deleted'',0=>''not deleted''',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `Capital` varchar(25) DEFAULT NULL,
  `NationalitySingular` varchar(35) DEFAULT NULL,
  `NationalityPlural` varchar(35) DEFAULT NULL,
  `Currency` varchar(30) DEFAULT NULL,
  `CurrencyCode` varchar(3) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=276 ;

-- --------------------------------------------------------

--
-- Table structure for table `emailtemplates`
--

CREATE TABLE IF NOT EXISTS `emailtemplates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `template_code` varchar(200) NOT NULL,
  `name` varchar(55) NOT NULL,
  `template` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE IF NOT EXISTS `faqs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=>''deleted'',0=>''not deleted''',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(100) NOT NULL,
  `company_id` int(11) NOT NULL,
  `added_by` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0->''admin'',''1''=>''users''',
  `user_id` int(11) DEFAULT NULL COMMENT 'id of user, who added the item',
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `old_category_id` int(11) NOT NULL,
  `product_code` varchar(200) NOT NULL COMMENT 'Unique product code',
  `product_weight` decimal(7,2) NOT NULL COMMENT 'per unit weight',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=>''active'',0 =>''inactive''',
  `is_featured` tinyint(4) NOT NULL DEFAULT '0' COMMENT '''0''=>''No'',''1''=>''Yes''',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=>''deleted'',0=>''not deleted''',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `item_categories`
--

CREATE TABLE IF NOT EXISTS `item_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `item_images`
--

CREATE TABLE IF NOT EXISTS `item_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `controller` varchar(255) NOT NULL,
  `created` date NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

CREATE TABLE IF NOT EXISTS `newsletters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `newsletter_template_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `send_type` tinyint(4) NOT NULL COMMENT '0=>''Send'',1=>Schedule',
  `schedule_date` date NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=>''deleted'',0=>''not deleted''',
  `is_sent` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=>not sent, 1=>sent',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_templates`
--

CREATE TABLE IF NOT EXISTS `newsletter_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `template` text NOT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT '0' COMMENT '1=>''deleted'',0=>''not deleted''',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `order_no` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `name_on_card` varchar(200) NOT NULL,
  `cc_number` varchar(100) NOT NULL,
  `exp_month` varchar(100) NOT NULL,
  `exp_year` varchar(100) NOT NULL,
  `card_type` varchar(100) NOT NULL,
  `cvv` int(11) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `is_recurring` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=> yes ,0 =>No',
  `payment_date` date DEFAULT NULL,
  `profile_id` varchar(255) DEFAULT NULL,
  `billing_name` varchar(255) NOT NULL,
  `billing_street_1` varchar(255) NOT NULL,
  `billing_street_2` varchar(255) NOT NULL,
  `billing_city` varchar(255) NOT NULL,
  `billing_state` varchar(255) NOT NULL,
  `billing_zip` varchar(255) NOT NULL,
  `billing_email` varchar(255) NOT NULL,
  `shipping_name` varchar(255) NOT NULL,
  `shipping_street_1` varchar(255) NOT NULL,
  `shipping_street_2` varchar(255) NOT NULL,
  `shipping_city` varchar(255) NOT NULL,
  `shipping_state` varchar(255) NOT NULL,
  `shipping_zip` varchar(255) NOT NULL,
  `shipping_phone` varchar(255) NOT NULL,
  `billing_phone` varchar(255) NOT NULL,
  `order_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=>In Progress,1=>Shipped,2=>Cancelled',
  `payment_status` tinyint(4) NOT NULL COMMENT '0=>Pending,1=>paid',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=>''deleted'',0=>''not deleted''',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `per_product_cost` varchar(100) DEFAULT NULL,
  `shipping_cost` varchar(100) DEFAULT NULL,
  `tax` varchar(100) DEFAULT NULL,
  `tax_amt` int(100) DEFAULT NULL,
  `total_cost` decimal(10,2) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `related_items`
--

CREATE TABLE IF NOT EXISTS `related_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `other_item_id` int(11) NOT NULL,
  `created` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE IF NOT EXISTS `role_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `permission_ids` varchar(255) NOT NULL,
  `created` date NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `api_sign` varchar(255) NOT NULL,
  `api_user` varchar(255) NOT NULL,
  `api_pass` varchar(255) NOT NULL,
  `enviroment` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=''Live'',0=>''Sandbox''',
  `braintree_merchant_id` varchar(255) NOT NULL,
  `braintree_public_key` varchar(255) NOT NULL,
  `braintree_private_key` varchar(255) NOT NULL,
  `braintree_environment` varchar(255) NOT NULL,
  `twilio_sid` varchar(255) DEFAULT NULL,
  `twilio_auth_token` varchar(255) DEFAULT NULL,
  `twilio_phone_no` varchar(100) DEFAULT NULL,
  `twilio_enviroment` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE IF NOT EXISTS `states` (
  `id` bigint(6) NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `country_id` bigint(6) NOT NULL,
  `name` varchar(45) NOT NULL,
  `Code` varchar(8) NOT NULL,
  `abbrev_name` varchar(100) NOT NULL,
  `ADM1Code` char(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5400 ;

-- --------------------------------------------------------

--
-- Table structure for table `staticpages`
--

CREATE TABLE IF NOT EXISTS `staticpages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `keyword` varchar(100) DEFAULT NULL,
  `meta_description` text,
  `meta_tag` varchar(100) DEFAULT NULL,
  `page_name` varchar(30) NOT NULL,
  `page_position` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=>''header'',1=>''footer'',2=>''leftnav''',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=>''deleted'',0=>''not deleted''',
  `status` tinyint(4) NOT NULL COMMENT '0=>inactive, 1=>''active''',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE IF NOT EXISTS `subscriptions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `frequency` tinyint(2) NOT NULL COMMENT '1=weekly,2=monthly,3=yearly',
  `amount` decimal(10,2) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0=>inactive, 1=>''active''',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=>''deleted'',0=>''not deleted''',
  `is_recurring` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=>''yes'',0=>''No''',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Subscription Packages' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ui_settings`
--

CREATE TABLE IF NOT EXISTS `ui_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL DEFAULT '1',
  `file_type` tinyint(4) NOT NULL COMMENT '0: css, 1 : js',
  `content` blob NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `first_name` varchar(55) NOT NULL,
  `last_name` varchar(55) NOT NULL,
  `email` varchar(55) NOT NULL,
  `gender` tinyint(4) NOT NULL COMMENT '1=>''Male'',0=>''Female''',
  `username` varchar(55) NOT NULL,
  `password` varchar(55) NOT NULL,
  `image` varchar(55) NOT NULL,
  `address_1` varchar(200) NOT NULL,
  `address_2` varchar(100) DEFAULT NULL,
  `country_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city` varchar(50) NOT NULL,
  `zip` int(11) NOT NULL,
  `phone_no` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=>''deleted'',0=>''not deleted''',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

CREATE TABLE IF NOT EXISTS `user_addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `shipping_name` varchar(30) NOT NULL,
  `shipping_street` varchar(100) NOT NULL,
  `shipping_street2` varchar(100) NOT NULL,
  `shipping_city` varchar(30) NOT NULL,
  `shipping_state` varchar(10) NOT NULL,
  `shipping_zip` varchar(20) NOT NULL,
  `return_name` varchar(30) NOT NULL,
  `return_street` varchar(100) NOT NULL,
  `return_street2` varchar(100) NOT NULL,
  `return_city` varchar(30) NOT NULL,
  `return_state` varchar(10) NOT NULL,
  `return_zip` varchar(20) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
