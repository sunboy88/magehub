<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('artists')};
CREATE TABLE {$this->getTable('artists')} (
  `artists_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `status` tinyint(2) NOT NULL,
  `category_id` int(11) unsigned NOT NULL,
  `biography` text CHARACTER SET utf8,
  `configaration` text,
  `website` text,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`artists_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- DROP TABLE IF EXISTS {$this->getTable('artists_category')};
CREATE TABLE {$this->getTable('artists_category')} (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Artists Category' AUTO_INCREMENT=1;

-- DROP TABLE IF EXISTS {$this->getTable('featured_artists')};
CREATE TABLE {$this->getTable('featured_artists')} (
  `artists_id` int(11) unsigned NOT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`artists_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- DROP TABLE IF EXISTS {$this->getTable('artists_image')};
CREATE TABLE {$this->getTable('artists_image')} (
  `artists_id` int(11) unsigned NOT NULL,
  `image` varchar(255) NOT NULL,
  `unique_index` int(11) NOT NULL,
  PRIMARY KEY (`artists_id`,`unique_index`),
  KEY `artists_id` (`artists_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- DROP TABLE IF EXISTS {$this->getTable('artist_apply_info')};
CREATE TABLE {$this->getTable('artist_apply_info')} (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `contact_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `band` varchar(255) NOT NULL,
  `website` text,
  `years` int(4) NOT NULL,
  `band2` varchar(255) DEFAULT NULL,
  `tours` date DEFAULT NULL,
  `tv` date DEFAULT NULL,
  `video` text,
  `record` varchar(255) DEFAULT NULL,
  `labelcontact` varchar(255) DEFAULT NULL,
  `labelphone` varchar(50) DEFAULT NULL,
  `labelsite` text,
  `current` varchar(255) DEFAULT NULL,
  `release` date DEFAULT NULL,
  `sold` int(11) DEFAULT NULL,
  `previous` varchar(255) DEFAULT NULL,
  `management` varchar(255) DEFAULT NULL,
  `managementperson` varchar(255) DEFAULT NULL,
  `managementcontact` varchar(50) DEFAULT NULL,
  `managementwebsite` text,
  `referred` varchar(255) DEFAULT NULL,
  `drum` varchar(255) DEFAULT NULL,
  `contract` varchar(100) DEFAULT NULL,
  `deal` varchar(255) DEFAULT NULL,
  `drumkit` text,
  `comments` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- DROP TABLE IF EXISTS {$this->getTable('artists_configaration')};
CREATE TABLE {$this->getTable('artists_configaration')} (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `admin_email` varchar(255) DEFAULT NULL,
  `address` text,
  `short_description` text,
  `email_template` text,
  `page_title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

");

$installer->endSetup();

/** Save Configaration Information at The time of Install **/
$data = array(
    'admin_email' => 'jahangir@evatix.com',
    'address' => '<p><strong> Spaun Drum Company<br /> Attn: Artist Relations<br /> 5505 Daniels Street<br /> Chino, CA 91710 </strong></p>',
    'short_description' => '<p>In addition to submitting this application, please mail your latest album, videos, photos, complete tour info (past, present, future), press clippings, etc. to:</p>',
    'email_template' => 'Email Template',
    'page_title' => 'Sponsorhsip/Endorsement Application'
);

Mage::getModel('artists/configaration')
         ->setData($data)
         ->save();

