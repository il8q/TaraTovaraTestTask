Настройки подключеняя к базе данных лежат в DatabaseConnectionFactory:

    $pdo = new PDOConnector(
        'localhost',
        'userName',
        'password',
        'dbName'
    );

Если не будет работать запрос с GROUP BY, возникающую ошибку (SELECT list is not in GROUP BY clause and contains nonaggregated column .... incompatible with sql_mode=only_full_group_by) можно решить вводом запроса:

    SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));