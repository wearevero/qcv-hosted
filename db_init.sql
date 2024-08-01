DROP DATABASE IF EXISTS qcventorydb;
CREATE DATABASE qcventorydb;
CREATE USER user_qcvdb@% IDENTIFIED BY 'qcvdbP4$$';
GRANT ALL PRIVILEGES ON qcventorydb.* TO user_qcvdb@% WITH GRANT OPTION;
FLUSH PRIVILEGES;

-- enable create user@%
-- find my.cnf
[mysqld]
skip-networking=0
skip-bind-address