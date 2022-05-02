FROM mysql:5.7
#COPY initdb.sql /tmp/
COPY docker.cnf /etc/mysql/conf.d/docker.cnf
EXPOSE 3306
CMD ["mysqld"]
#CMD ["sh", "-c", "mysql_upgrade -proot; mysqld --user=root"]
