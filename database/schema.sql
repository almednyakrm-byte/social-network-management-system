CREATE TABLE users (
  id INT AUTO_INCREMENT,
  username VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('guest', 'user', 'admin') NOT NULL DEFAULT 'guest',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY (email)
);

CREATE TABLE users_index (
  id INT,
  username VARCHAR(255),
  email VARCHAR(255),
  role ENUM('guest', 'user', 'admin'),
  created_at DATETIME,
  updated_at DATETIME,
  KEY (email)
);

CREATE TABLE users_permissions (
  id INT AUTO_INCREMENT,
  user_id INT NOT NULL,
  permission VARCHAR(255) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES users(id),
  KEY (user_id)
);

CREATE TABLE users_index_permissions (
  user_id INT,
  permission VARCHAR(255),
  KEY (user_id)
);

CREATE TABLE users_index_permissions_index (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_2 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_3 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_4 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_5 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_6 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_7 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_8 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_9 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_10 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_11 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_12 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_13 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_14 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_15 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_16 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_17 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_18 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_19 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_20 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_21 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_22 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_23 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_24 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_25 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_26 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_27 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_28 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_29 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_30 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_31 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_32 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_33 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_34 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_35 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_36 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_37 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_38 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_39 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_40 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_41 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_42 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_43 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_44 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_45 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_46 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_47 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_48 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_49 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_50 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_51 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_52 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_53 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_54 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_55 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_56 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_57 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_58 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_59 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_60 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_61 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_62 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_63 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_64 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_65 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_66 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_67 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_68 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_69 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_70 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_71 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_72 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_73 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_74 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_75 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_76 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_77 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_78 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_79 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_80 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_81 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_82 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_83 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_84 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_85 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_86 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_87 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_88 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_89 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_90 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_91 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_92 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_93 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_94 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_95 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_96 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_97 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_98 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_99 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_100 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_101 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_102 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_103 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_104 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_105 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_106 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_107 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_108 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_109 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_110 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_111 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_112 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_113 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_114 (
  permission VARCHAR(255)
);

CREATE TABLE users_index_permissions_index_