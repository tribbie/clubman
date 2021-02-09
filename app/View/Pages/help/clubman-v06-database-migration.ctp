<pre>
  # make snapshot (backup) from members table
  # DROP TABLE `cm_members_backup`;
  CREATE TABLE `cm_members_backup` LIKE cm_members;
  INSERT `cm_members_backup` SELECT * FROM cm_members;


  # make work table migratemembers and feed data from members
  # DROP TABLE `cm_migratemembers`;
  CREATE TABLE cm_migratemembers LIKE cm_members;
  INSERT cm_migratemembers SELECT * FROM cm_members;
  # modify this migrate table
  ALTER TABLE cm_migratemembers ADD COLUMN person_id INT(11) UNSIGNED DEFAULT NULL AFTER ID;
  ALTER TABLE cm_migratemembers MODIFY COLUMN licensenumber VARCHAR(20);


  # make new persons table
  # DROP TABLE `cm_persons`;
  CREATE TABLE `cm_persons` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `picture_id` int(11) unsigned DEFAULT NULL,
    `contactaddress_id` int(11) unsigned DEFAULT NULL,
    `uniquenumber` char(255) DEFAULT NULL,
    `lastname` varchar(64) NOT NULL,
    `firstname` varchar(64) NOT NULL,
    `gender` varchar(16) DEFAULT NULL,
    `birthdate` date DEFAULT NULL,
    `birthday_public` tinyint(1) DEFAULT NULL,
    `email` varchar(255) DEFAULT NULL,
    `mobile` varchar(40) DEFAULT NULL,
    `bankaccount` varchar(48) DEFAULT NULL,
    `nickname` varchar(64) DEFAULT NULL,
    `status` varchar(16) DEFAULT NULL,
    `remark` varchar(255) DEFAULT NULL,
    `metadata` varchar(255) DEFAULT NULL,
    `created` datetime DEFAULT NULL,
    `modified` datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;


  # make new parent relations table
  # DROP TABLE `cm_personparents`;
  CREATE TABLE `cm_personparents` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `person_id` int(11) unsigned DEFAULT NULL,
    `parent_id` int(11) unsigned DEFAULT NULL,
    `type` varchar(64) DEFAULT NULL,
    `remark` varchar(255) DEFAULT NULL,
    `metadata` varchar(255) DEFAULT NULL,
    `created` datetime DEFAULT NULL,
    `modified` datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;


  # make new contact addresses table
  # DROP TABLE `cm_contactaddresses`;
  CREATE TABLE `cm_contactaddresses` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `address` varchar(64) DEFAULT NULL,
    `street` varchar(128) DEFAULT NULL,
    `streetnumber` varchar(16) DEFAULT NULL,
    `streetnumbersuffix` varchar(16) DEFAULT NULL,
    `postcode` varchar(16) DEFAULT NULL,
    `city` varchar(64) DEFAULT NULL,
    `countrycode` char(2) DEFAULT NULL,
    `landline` varchar(40) DEFAULT NULL,
    `remark` varchar(255) DEFAULT NULL,
    `metadata` varchar(255) DEFAULT NULL,
    `created` datetime DEFAULT NULL,
    `modified` datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;


  # Put person data from members table in persons table

  # Add mom parents data from members table into parent relations table
  # Add dad parents data from members table into contactaddresses table

  # Add dad parents data from members table into parent relations table
  # Add dad parents data from members table into contactaddresses table

  # Merge doubles (where mom or dad are also members) in
  # - in the persons table
  # - in the personsparents table
  # Merge doubles (where members or moms or dads have the same address) in
  # - in the contactaddresses table

  # reduce the members table into the new members table
  # - add a foreign key for the persons table
  # - remove the migrated columns

  # perform a final check


  # make new table memberships and feed data from worktable migratemembers
  # DROP TABLE `cm_memberships`;
  CREATE TABLE cm_memberships LIKE cm_migratemembers;
  INSERT cm_memberships SELECT * FROM cm_migratemembers;
  ALTER TABLE cm_memberships
   DROP COLUMN picture_id,
   DROP COLUMN lastname,
   DROP COLUMN firstname,
   DROP COLUMN birthdate,
   DROP COLUMN birthday_public,
   DROP COLUMN email,
   DROP COLUMN tel,
   DROP COLUMN address,
   DROP COLUMN postcode,
   DROP COLUMN city,
   DROP COLUMN nationalnumber,
   DROP COLUMN mom_lastname,
   DROP COLUMN mom_firstname,
   DROP COLUMN mom_email,
   DROP COLUMN mom_tel,
   DROP COLUMN mom_address,
   DROP COLUMN mom_postcode,
   DROP COLUMN mom_city,
   DROP COLUMN dad_lastname,
   DROP COLUMN dad_firstname,
   DROP COLUMN dad_email,
   DROP COLUMN dad_tel,
   DROP COLUMN dad_address,
   DROP COLUMN dad_postcode,
   DROP COLUMN dad_city,
   DROP COLUMN nickname,
   DROP COLUMN bank_account;

  # Some more small migrations for other purposes

  # for password reset (preparation) - possibly already in the database (VCW and VCE)
  ALTER TABLE cm_users ADD COLUMN reset datetime DEFAULT NULL AFTER role;
  ALTER TABLE cm_users ADD COLUMN resetkey binary(32) NOT NULL AFTER role;


</pre>
