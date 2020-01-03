<?php

require_once (dirname(dirname(__FILE__)) ."/factories/FactoryConnectMYSQL.php");

class UserRepository{

    public function getAccountByLoginPassword($login, $password){
 
        $factoryConnection = new FactoryConnectMYSQL();

        $sql = "
            SELECT * FROM accounts WHERE accno = :account AND password = :password;
        ";

        if (!$sth = $factoryConnection::$conn->prepare($sql))
            throw new Exception("Erro ao consultar o login na base de dados!");
        
        if (!$sth->bindParam(":account", $login, PDO::PARAM_STR))
            throw new Exception("Erro ao consultar o login na base de dados");

        if (!$sth->bindParam(":password", $password, PDO::PARAM_STR))
            throw new Exception("Erro ao consultar o login na base de dados");
        
        if (!$sth->execute())
            throw new Exception("Erro ao consultar o login na base de dados");

        if ($sth->rowCount() <= 0)
            return null;

        $factoryConnection->desconnect();

        return $sth->fetch(PDO::FETCH_OBJ);

    }

    public function getAccountById($id){

        $factoryConnection = new FactoryConnectMYSQL();

        $sql = "
            SELECT accounts.*, account_point.points FROM accounts
            LEFT JOIN account_point
                ON accounts.id = account_point.idAccount
            WHERE id = :id;
        ";

        if (!$sth = $factoryConnection::$conn->prepare($sql))
            throw new Exception("Erro ao consultar o login na base de dados!");
        
        if (!$sth->bindParam(":id", $id, PDO::PARAM_INT))
            throw new Exception("Erro ao consultar o login na base de dados");
        
        if (!$sth->execute())
            throw new Exception("Erro ao consultar o login na base de dados");

        if ($sth->rowCount() <= 0)
            return null;

        $factoryConnection->desconnect();

        return $sth->fetch(PDO::FETCH_OBJ);

    }

    public function getAccountByUserName($login){

        $factoryConnection = new FactoryConnectMYSQL();

        $sql = "
            SELECT * FROM accounts WHERE accno = :account;
        ";

        if (!$sth = $factoryConnection::$conn->prepare($sql))
            throw new Exception("Erro ao consultar o login na base de dados!");
        
        if (!$sth->bindParam(":account", $login, PDO::PARAM_STR))
            throw new Exception("Erro ao consultar o login na base de dados");
        
        if (!$sth->execute())
            throw new Exception("Erro ao consultar o login na base de dados");

        if ($sth->rowCount() <= 0)
            return null;

        $factoryConnection->desconnect();

        return $sth->fetch(PDO::FETCH_OBJ);

    }

    public function createAccount($login, $password){

        $factoryConnection = new FactoryConnectMYSQL();

        $sql = "
            INSERT INTO accounts(accno, password, type, premDays, email, blocked, rlname, location, hide, hidemail)VALUES(:account, :password, 1, 0, '', 0, '', '', 0, 0);
        ";

        if (!$sth = $factoryConnection::$conn->prepare($sql))
            throw new Exception("Erro ao consultar o login na base de dados!");
        
        if (!$sth->bindParam(":account", $login, PDO::PARAM_STR))
            throw new Exception("Erro ao consultar o login na base de dados");
        
        if (!$sth->bindParam(":password", $password, PDO::PARAM_STR))
            throw new Exception("Erro ao consultar o login na base de dados");
        
        if (!$sth->execute())
            throw new Exception("Erro ao consultar o login na base de dados");

        $id = $factoryConnection::$conn->lastInsertId();

        session_start();
        $_SESSION["id_user"] = $id;

        $factoryConnection->desconnect();

    }

    public function getPlayerByName($name){

        $factoryConnection = new FactoryConnectMYSQL();

        $sql = "
            SELECT 
                players.id,
                players.name,
                IF(players.promoted = 1, 
                (CASE players.vocation
                    WHEN 1 THEN 'Master Sorcerer'
                    WHEN 2 THEN 'Elder Druid'
                    WHEN 3 THEN 'Royal Paladin'
                    WHEN 4 THEN 'Elite Knight'
                END),
                CASE players.vocation
                    WHEN 1 THEN 'Sorcerer'
                    WHEN 2 THEN 'Druid'
                    WHEN 3 THEN 'Paladin'
                    WHEN 4 THEN 'Knight'
                END) vocation,
                players.experience,
                IF(players.sex = 0, 'Feminino', 'Masculino') sex,
                players.level skillLevel,
                players.maglevel skillMaglevel,
                skillFist.skill skillFist,
                skillClub.skill skillClub,
                skillSword.skill skillSword,
                skillAxe.skill skillAxe,
                skillDistance.skill skillDistance,
                skillShield.skill skillShield,
                skillFish.skill skillFish
            FROM players
            LEFT JOIN skills skillFist
                ON players.id = skillFist.player
                    AND skillFist.id = 0
            LEFT JOIN skills skillClub
                ON players.id = skillClub.player
                    AND skillClub.id = 1
            LEFT JOIN skills skillSword
                ON players.id = skillSword.player
                    AND skillSword.id = 2
            LEFT JOIN skills skillAxe
                ON players.id = skillAxe.player
                    AND skillAxe.id = 3
            LEFT JOIN skills skillDistance
                ON players.id = skillDistance.player
                    AND skillDistance.id = 4
            LEFT JOIN skills skillShield
                ON players.id = skillShield.player
                    AND skillShield.id = 5
            LEFT JOIN skills skillFish
                ON players.id = skillFish.player
                    AND skillFish.id = 6
            WHERE name LIKE :name AND access <= 0;
        ";

        if (!$sth = $factoryConnection::$conn->prepare($sql))
            throw new Exception("Erro ao consultar character!");
        
        if (!$sth->bindParam(":name", $name, PDO::PARAM_STR))
            throw new Exception("Erro ao consultar character");
        
        if (!$sth->execute())
            throw new Exception("Erro ao consultar character");

        $factoryConnection->desconnect();

        if ($sth->rowCount() <= 0)
            throw new Exception("O character não foi encontrado na base de dados!");

        $character = $sth->fetch(PDO::FETCH_OBJ);
        $character->deaths = $this->getDeathsByPlayerName($character->name);
        $character->kills  = $this->getKillsByPlayerName($character->name);
        
        return $character;

    }

    public function getDeathsByPlayerName($name){

        $factoryConnection = new FactoryConnectMYSQL();

        $sql = "
            SELECT 
                deathlist.*,
                players.id playerId
            FROM deathlist
            LEFT JOIN players
                ON deathlist.killer = players.name
            WHERE 
                deathlist.name = :name
            ORDER BY date ASC;
        ";

        if (!$sth = $factoryConnection::$conn->prepare($sql))
            throw new Exception("Erro ao consultar character!");
        
        if (!$sth->bindParam(":name", $name, PDO::PARAM_STR))
            throw new Exception("Erro ao consultar character");
        
        if (!$sth->execute())
            throw new Exception("Erro ao consultar character");

        $factoryConnection->desconnect();

        if ($sth->rowCount() <= 0)
            return [];

        $return = [];

        while($row = $sth->fetch(PDO::FETCH_OBJ)){
            $return[] = $row;
        }

        return $return;
    }

    public function getKillsByPlayerName($name){
        $factoryConnection = new FactoryConnectMYSQL();

        $sql = "
            SELECT 
                deathlist.*,
                players.id playerId
            FROM deathlist
            LEFT JOIN players
                ON deathlist.killer = players.name
            WHERE 
                deathlist.killer = :name
            ORDER BY date ASC;
        ";

        if (!$sth = $factoryConnection::$conn->prepare($sql))
            throw new Exception("Erro ao consultar character!");
        
        if (!$sth->bindParam(":name", $name, PDO::PARAM_STR))
            throw new Exception("Erro ao consultar character");
        
        if (!$sth->execute())
            throw new Exception("Erro ao consultar character");

        $factoryConnection->desconnect();

        if ($sth->rowCount() <= 0)
            return [];

        $return = [];

        while($row = $sth->fetch(PDO::FETCH_OBJ)){
            $return[] = $row;
        }

        return $return;
    }

    public function getRaking($type, $idSkill = null){

        $factoryConnection = new FactoryConnectMYSQL();

        switch ($type){
            case "level":
                $sql = "
                    SELECT 
                        name,
                        level skill
                    FROM players
                    WHERE access <= 0
                    ORDER BY level DESC;
                ";
            break;
            case "magic-level":
                $sql = "
                    SELECT 
                        name,
                        maglevel skill
                    FROM players
                    WHERE access <= 0
                    ORDER BY maglevel DESC;
                ";
            break;
            default:
                $sql = "
                    SELECT 
                        players.name,
                        skills.skill
                    FROM skills
                    INNER JOIN players
                        ON skills.player = players.id
                    WHERE skills.id = :id
                    ORDER BY skill DESC;
                ";
            break;
        }

        if (!$sth = $factoryConnection::$conn->prepare($sql))
            throw new Exception("Erro ao listar ranking solicitado!");

        if ($type !== "level" && $type !== "magic=level"){
            if (!$sth->bindParam(":id", $idSkill, PDO::PARAM_INT))
                throw new Exception("Erro ao listar ranking solicitado");
        }

        if (!$sth->execute())
            throw new Exception("Erro ao listar ranking solicitado");

        $factoryConnection->desconnect();

        if ($sth->rowCount() <= 0)
            return [];

        $return = [];

        while($row = $sth->fetch(PDO::FETCH_OBJ)){
            $return[] = $row;
        }

        return $return;
        
    }

    public function getCharacters($account){
        
        $factoryConnection = new FactoryConnectMYSQL();

        $sql = "
            SELECT 
                players.id,
                players.name,
                IF(players.promoted = 1, 
                (CASE players.vocation
                    WHEN 1 THEN 'Master Sorcerer'
                    WHEN 2 THEN 'Elder Druid'
                    WHEN 3 THEN 'Royal Paladin'
                    WHEN 4 THEN 'Elite Knight'
                END),
                CASE players.vocation
                    WHEN 1 THEN 'Sorcerer'
                    WHEN 2 THEN 'Druid'
                    WHEN 3 THEN 'Paladin'
                    WHEN 4 THEN 'Knight'
                END) vocation,
                players.experience,
                IF(players.sex = 0, 'Feminino', 'Masculino') sex,
                players.level skillLevel,
                players.maglevel skillMaglevel,
                skillFist.skill skillFist,
                skillClub.skill skillClub,
                skillSword.skill skillSword,
                skillAxe.skill skillAxe,
                skillDistance.skill skillDistance,
                skillShield.skill skillShield,
                skillFish.skill skillFish
            FROM players
            LEFT JOIN skills skillFist
                ON players.id = skillFist.player
                    AND skillFist.id = 0
            LEFT JOIN skills skillClub
                ON players.id = skillClub.player
                    AND skillClub.id = 1
            LEFT JOIN skills skillSword
                ON players.id = skillSword.player
                    AND skillSword.id = 2
            LEFT JOIN skills skillAxe
                ON players.id = skillAxe.player
                    AND skillAxe.id = 3
            LEFT JOIN skills skillDistance
                ON players.id = skillDistance.player
                    AND skillDistance.id = 4
            LEFT JOIN skills skillShield
                ON players.id = skillShield.player
                    AND skillShield.id = 5
            LEFT JOIN skills skillFish
                ON players.id = skillFish.player
                    AND skillFish.id = 6
            WHERE account = :account AND access <= 0;
        ";

        if (!$sth = $factoryConnection::$conn->prepare($sql))
            throw new Exception("Erro ao listar characters!");

        if (!$sth->bindParam(":account", $account, PDO::PARAM_STR))
            throw new Exception("Erro ao listar characters!");

        if (!$sth->execute())
            throw new Exception("Erro ao listar characters!");

        $factoryConnection->desconnect();

        if ($sth->rowCount() <= 0)
            return [];

        $return = [];

        while($row = $sth->fetch(PDO::FETCH_OBJ)){
            $return[] = $row;
        }

        return $return;
    }

    public function getPlayerById($id){

        $factoryConnection = new FactoryConnectMYSQL();

        $sql = "
            SELECT 
                accounts.id as accid,
                players.id,
                players.name,
                IF(players.promoted = 1, 
                (CASE players.vocation
                    WHEN 1 THEN 'Master Sorcerer'
                    WHEN 2 THEN 'Elder Druid'
                    WHEN 3 THEN 'Royal Paladin'
                    WHEN 4 THEN 'Elite Knight'
                END),
                CASE players.vocation
                    WHEN 1 THEN 'Sorcerer'
                    WHEN 2 THEN 'Druid'
                    WHEN 3 THEN 'Paladin'
                    WHEN 4 THEN 'Knight'
                END) vocation,
                players.experience,
                IF(players.sex = 0, 'Feminino', 'Masculino') sex,
                players.level skillLevel,
                players.maglevel skillMaglevel,
                skillFist.skill skillFist,
                skillClub.skill skillClub,
                skillSword.skill skillSword,
                skillAxe.skill skillAxe,
                skillDistance.skill skillDistance,
                skillShield.skill skillShield,
                skillFish.skill skillFish
            FROM players
            LEFT JOIN skills skillFist
                ON players.id = skillFist.player
                    AND skillFist.id = 0
            LEFT JOIN skills skillClub
                ON players.id = skillClub.player
                    AND skillClub.id = 1
            LEFT JOIN skills skillSword
                ON players.id = skillSword.player
                    AND skillSword.id = 2
            LEFT JOIN skills skillAxe
                ON players.id = skillAxe.player
                    AND skillAxe.id = 3
            LEFT JOIN skills skillDistance
                ON players.id = skillDistance.player
                    AND skillDistance.id = 4
            LEFT JOIN skills skillShield
                ON players.id = skillShield.player
                    AND skillShield.id = 5
            LEFT JOIN skills skillFish
                ON players.id = skillFish.player
                    AND skillFish.id = 6
            LEFT JOIN accounts on accounts.accno = players.account
            WHERE players.id = :id AND access <= 0;
        ";

	$sth = $factoryConnection::$conn->prepare($sql);
	$sth->bindParam(":id", $id, PDO::PARAM_STR);
	$sth->execute();
	$factoryConnection->desconnect();

        /*if (!$sth = $factoryConnection::$conn->prepare($sql))
            throw new Exception("Erro ao consultar character!");
        
        if (!$sth->bindParam(":id", $id, PDO::PARAM_STR))
            throw new Exception("Erro ao consultar character");
        
        if (!$sth->execute())
            throw new Exception("Erro ao consultar character");

        $factoryConnection->desconnect();

        if ($sth->rowCount() <= 0)
            throw new Exception("O character não foi encontrado na base de dados!");*/

        $character = $sth->fetch(PDO::FETCH_OBJ);

        return $character;

    }

    public function getCharByName($name){

        $factoryConnection = new FactoryConnectMYSQL();

        $sql = "SELECT * FROM players WHERE name LIKE :name;";

        if (!$sth = $factoryConnection::$conn->prepare($sql))
            throw new Exception("Erro ao buscar character pelo nome!");

        if (!$sth->bindParam(":name", $name, PDO::PARAM_STR))
            throw new Exception("Erro ao buscar character pelo nome!");

        if (!$sth->execute())
            throw new Exception("Erro ao buscar character pelo nome!");

        $factoryConnection->desconnect();

        if ($sth->rowCount() <= 0)
            return null;

        return $sth->fetch(PDO::FETCH_OBJ);

    }

    public function save($data){
        
        $charModel = file_get_contents(dirname(dirname(__FILE__))."/data/char_model.json");
        $charModel = json_decode($charModel);

        switch($data->vocation){
            case '1':
                $charVocation = $charModel->sorcerer;
            break;
            case '2':
                $charVocation = $charModel->druid;
            break;
            case '3':
                $charVocation = $charModel->paladin;
            break;
            case '4':
                $charVocation = $charModel->knight;
            break;
        }

        $factoryConnection = new FactoryConnectMYSQL();

        try {
            
            $factoryConnection::$conn->beginTransaction();

            //Cria o player
            $sql = "
                INSERT INTO players(
                    name, 
                    access, 
                    account, 
                    level, 
                    vocation, 
                    cid, 
                    health, 
                    healthmax, 
                    direction, 
                    experience, 
                    lookbody, 
                    lookfeet, 
                    lookhead, 
                    looklegs, 
                    looktype, 
                    maglevel, 
                    mana, 
                    manamax, 
                    manaspent, 
                    masterpos, 
                    pos, 
                    speed, 
                    cap, 
                    maxdepotitems, 
                    food, 
                    sex, 
                    guildid, 
                    guildrank, 
                    guildnick, 
                    lastlogin, 
                    lastip, 
                    save, 
                    redskulltime, 
                    redskull
                )VALUES(
                    :name, 
                    :access, 
                    :account, 
                    :level, 
                    :vocation, 
                    :cid, 
                    :health, 
                    :healthmax, 
                    :direction, 
                    :experience, 
                    :lookbody, 
                    :lookfeet, 
                    :lookhead, 
                    :looklegs, 
                    :looktype, 
                    :maglevel, 
                    :mana, 
                    :manamax, 
                    :manaspent, 
                    :masterpos, 
                    :pos, 
                    :speed, 
                    :cap, 
                    :maxdepotitems, 
                    :food, 
                    :sex, 
                    :guildid, 
                    :guildrank, 
                    :guildnick, 
                    :lastlogin, 
                    :lastip, 
                    :save, 
                    :redskulltime, 
                    :redskull
                );
            ";

            if (!$sth = $factoryConnection::$conn->prepare($sql))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":name", $data->name, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":access", $charModel->access, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":account", $data->account, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":level", $charModel->startlvl, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":vocation", $data->vocation, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":cid", $charModel->cid, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":health", $charVocation->hp, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":healthmax", $charVocation->hp, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":direction", $charModel->direction, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":experience", $charModel->startexp, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":lookbody", $charModel->lookbody, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":lookfeet", $charModel->lookfeet, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":lookhead", $charModel->lookhead, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":looklegs", $charModel->looklegs, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":looktype", $charModel->looktype, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":maglevel", $charVocation->mag, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":mana", $charVocation->mana, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":manamax", $charVocation->mana, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":manaspent", $charModel->manaspent, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":masterpos", $charModel->templepos, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":pos", $charModel->templepos, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":speed", $charModel->startspeed, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":cap", $charVocation->cap, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":maxdepotitems", $charModel->maxdepotitems, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":food", $charModel->food, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":sex", $data->sex, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":guildid", $charModel->guildid, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":guildrank", $charModel->guildrank, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":guildnick", $charModel->guildnick, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":lastlogin", $charModel->lastlogin, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":lastip", $charModel->lastip, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":save", $charModel->save, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":redskulltime", $charModel->redskulltime, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->bindParam(":redskull", $charModel->redskull, PDO::PARAM_STR))
                throw new Exception("Erro ao criar player no server!");

            if (!$sth->execute())
                throw new Exception("Erro ao criar player no server!");
            
            //Recupera o player id
            $idPlayer = $factoryConnection::$conn->lastInsertId();
            
            //Preenche os itens do player
            $sql = "
                INSERT INTO items(
                    player, 
                    slot, 
                    sid, 
                    pid, 
                    type, 
                    number,
                    actionid, 
                    text, 
                    specialdesc
                )VALUES(
                    :player,
                    :slot,
                    :sid,
                    :pid,
                    :type,
                    :number,
                    :actionid,
                    :text,
                    :specialdesc
                );
            ";
            
            foreach($charVocation->items AS $item){

                if (!$sth = $factoryConnection::$conn->prepare($sql))
                    throw new Exception("Erro ao criar item do player no server!");

                if (!$sth->bindParam(":player", $idPlayer, PDO::PARAM_STR))
                    throw new Exception("Erro ao criar item do player no server!");

                if (!$sth->bindParam(":slot", $item->slot, PDO::PARAM_STR))
                    throw new Exception("Erro ao criar item do player no server!");

                if (!$sth->bindParam(":sid", $item->sid, PDO::PARAM_STR))
                    throw new Exception("Erro ao criar item do player no server!");

                if (!$sth->bindParam(":pid", $item->pid, PDO::PARAM_STR))
                    throw new Exception("Erro ao criar item do player no server!");

                if (!$sth->bindParam(":type", $item->type, PDO::PARAM_STR))
                    throw new Exception("Erro ao criar item do player no server!");

                if (!$sth->bindParam(":number", $item->number, PDO::PARAM_STR))
                    throw new Exception("Erro ao criar item do player no server!");

                if (!$sth->bindParam(":actionid", $item->actionid, PDO::PARAM_STR))
                    throw new Exception("Erro ao criar item do player no server!");

                if (!$sth->bindParam(":text", $item->text, PDO::PARAM_STR))
                    throw new Exception("Erro ao criar item do player no server!");

                if (!$sth->bindParam(":specialdesc", $item->specialdesc, PDO::PARAM_STR))
                    throw new Exception("Erro ao criar item do player no server!");

                if (!$sth->execute())
                    throw new Exception("Erro ao criar item do player no server!");

            }

            //Cria os skills do player
            $sql = "
                INSERT INTO skills(
                    player, 
                    id, 
                    skill, 
                    tries
                )VALUES(
                    :player,
                    :id,
                    :skill,
                    :tries
                );
            ";

            foreach($charVocation->skills AS $skill){

                if (!$sth = $factoryConnection::$conn->prepare($sql))
                    throw new Exception("Erro ao criar skill do player no server!");

                if (!$sth->bindParam(":player", $idPlayer, PDO::PARAM_STR))
                    throw new Exception("Erro ao criar skill do player no server!");

                if (!$sth->bindParam(":id", $skill->id, PDO::PARAM_STR))
                    throw new Exception("Erro ao criar skill do player no server!");

                if (!$sth->bindParam(":skill", $skill->skill, PDO::PARAM_STR))
                    throw new Exception("Erro ao criar skill do player no server!");

                if (!$sth->bindParam(":tries", $skill->tries, PDO::PARAM_STR))
                    throw new Exception("Erro ao criar skill do player no server!");

                if (!$sth->execute())
                    throw new Exception("Erro ao criar skill do player no server!");
            }

            $factoryConnection::$conn->commit();

        } catch(Exception $e){

            $factoryConnection::$conn->rollBack();
            throw new Exception($e->getMessage());

        }
    }

    public function delete($idPlayer){

        //Busca o player
        $player = $this->getPlayerById($idPlayer);

        $factoryConnection = new FactoryConnectMYSQL();

        try {
            
            $factoryConnection::$conn->beginTransaction();

            //Apaga os itens
            $sql = "
                DELETE FROM items WHERE player = :idPlayer;
            ";

            if (!$sth = $factoryConnection::$conn->prepare($sql))
                throw new Exception("Erro ao apagar os items do player!");
            
            if (!$sth->bindParam(":idPlayer", $idPlayer, PDO::PARAM_INT))
                throw new Exception("Erro ao apagar os items do player!");
            
            if (!$sth->execute())
                throw new Exception("Erro ao apagar os items do player!");

            //Apaga os skills
            $sql = "
                DELETE FROM skills WHERE player = :idPlayer;
            ";

            if (!$sth = $factoryConnection::$conn->prepare($sql))
                throw new Exception("Erro ao apagar os skills do player!");
            
            if (!$sth->bindParam(":idPlayer", $idPlayer, PDO::PARAM_INT))
                throw new Exception("Erro ao apagar os skills do player!");
            
            if (!$sth->execute())
                throw new Exception("Erro ao apagar os skills do player!");

            //Apaga os deaths
            $sql = "
                DELETE FROM deathlist WHERE name = :namePlayer;
            ";

            if (!$sth = $factoryConnection::$conn->prepare($sql))
                throw new Exception("Erro ao apagar os mortes do player!");
            
            if (!$sth->bindParam(":namePlayer", $player->name, PDO::PARAM_STR))
                throw new Exception("Erro ao apagar os mortes do player!");
            
            if (!$sth->execute())
                throw new Exception("Erro ao apagar os mortes do player!");

            //Apaga o player
            $sql = "
                DELETE FROM players WHERE id = :idPlayer;
            ";

            if (!$sth = $factoryConnection::$conn->prepare($sql))
                throw new Exception("Erro ao apagar o player!");
            
            if (!$sth->bindParam(":idPlayer", $idPlayer, PDO::PARAM_INT))
                throw new Exception("Erro ao apagar o player!");
            
            if (!$sth->execute())
                throw new Exception("Erro ao apagar o player!");

            $factoryConnection::$conn->commit();

        } catch(Exception $e) {

            $factoryConnection::$conn->rollBack();
            throw new Exception($e->getMessage());

        }
        
    }

    public function changePassword($account, $newPassword){

        $factoryConnection = new FactoryConnectMYSQL();

        $sql = "
            UPDATE accounts SET password = :password WHERE accno = :account;
        ";

        if (!$sth = $factoryConnection::$conn->prepare($sql))
            throw new Exception("Erro ao alterar a senha da conta!");
        
        if (!$sth->bindParam(":account", $account, PDO::PARAM_STR))
            throw new Exception("Erro ao alterar a senha da conta!");
        
        if (!$sth->bindParam(":password", $newPassword, PDO::PARAM_STR))
            throw new Exception("Erro ao alterar a senha da conta!");
        
        if (!$sth->execute())
            throw new Exception("Erro ao alterar a senha da conta!");

        $factoryConnection->desconnect();

    }

    public function getNumPlayerGOD(){

        $factoryConnection = new FactoryConnectMYSQL();

        if (!isset($_SESSION))
            session_start();
        
        $sql = "
            SELECT COUNT(*) Total FROM players
            INNER JOIN accounts
                ON players.account = accounts.accno
            WHERE players.access = 6 AND accounts.id = :idAccount;
        ";

        if (!$sth = $factoryConnection::$conn->prepare($sql))
            throw new Exception("Erro ao checar perfil de GOD!");
        
        if (!$sth->bindParam(":idAccount", $_SESSION["id_user"], PDO::PARAM_INT))
            throw new Exception("Erro ao checar perfil de GOD!");
        
        if (!$sth->execute())
            throw new Exception("Erro ao checar perfil de GOD!");

        $factoryConnection->desconnect();

        $row = $sth->fetch(PDO::FETCH_OBJ);

        return $row->Total;

    }

    public function getLastMoviments(){
        
        $factoryConnection = new FactoryConnectMYSQL();

        $sql = "
            SELECT 
                movimentType,
                DATE_FORMAT(dateTime, '%d/%m/%Y %H:%m:%s') dateTime,
                playerDebito,
                itemDebito,
                points
            FROM account_point_moviment
            ORDER BY dateTime DESC
            LIMIT 50;
        ";

        if (!$sth = $factoryConnection::$conn->prepare($sql))
            throw new Exception("Erro ao consultar os últimos movimentos!");

        if (!$sth->execute())
            throw new Exception("Erro ao consultar os últimos movimentos!");
        
        $factoryConnection->desconnect();

        $retorno = [];

        while($row = $sth->fetch(PDO::FETCH_OBJ)){
            $retorno[] = $row;
        }

        return $retorno;
    }

    public function getAllPlayers(){

        $factoryConnection = new FactoryConnectMYSQL();

        $sql = "
            SELECT 
                id,
                name
            FROM players
            WHERE access <= 0
            ORDER BY name;
        ";

        if (!$sth = $factoryConnection::$conn->prepare($sql))
            throw new Exception("Erro ao consultar players!");

        if (!$sth->execute())
            throw new Exception("Erro ao consultar players!");
        
        $factoryConnection->desconnect();

        $retorno = [];

        while($row = $sth->fetch(PDO::FETCH_OBJ)){
            $retorno[] = $row;
        }

        return $retorno;

    }

    public function getAccountByPlayerId($idPlayer){

        $factoryConnection = new FactoryConnectMYSQL();

        $sql = "
            SELECT accounts.* FROM players
            INNER JOIN accounts
                ON players.account = accounts.accno
            WHERE players.id = :idPlayer;
        ";

        if (!$sth = $factoryConnection::$conn->prepare($sql))
            throw new Exception("Erro ao consultar player!");
        
        if (!$sth->bindParam(":idPlayer", $idPlayer, PDO::PARAM_INT))
            throw new Exception("Erro ao consultar player!");
        
        if (!$sth->execute())
            throw new Exception("Erro ao consultar player!");

        $factoryConnection->desconnect();

        if ($sth->rowCount() <= 0)
            return null;

        $row = $sth->fetch(PDO::FETCH_OBJ);

        return $row;

    }

    public function concederPontos($idAccount, $numberPoints, $playerName){

        $factoryConnection = new FactoryConnectMYSQL();

        if (!isset($_SESSION))
            session_start();
        
        try {

            $factoryConnection::$conn->beginTransaction();

            $sql = "
                INSERT INTO account_point_moviment(
                    idAccount, 
                    movimentType, 
                    playerDebito, 
                    itemDebito, 
                    dateTime, 
                    points, 
                    idAccountMoviment
                )VALUES(
                    :idAccount,
                    'DEPOSITO',
                    :playerName,
                    'points',
                    NOW(),
                    :numberPoints,
                    :idAccountMoviment
                );
            ";

            if (!$sth = $factoryConnection::$conn->prepare($sql))
                throw new Exception("Erro ao conceder pontos para o player!");
            
            if (!$sth->bindParam(":idAccount", $idAccount, PDO::PARAM_INT))
                throw new Exception("Erro ao conceder pontos para o player!");

            if (!$sth->bindParam(":playerName", $playerName, PDO::PARAM_STR))
                throw new Exception("Erro ao conceder pontos para o player!");

            if (!$sth->bindParam(":numberPoints", $numberPoints, PDO::PARAM_INT))
                throw new Exception("Erro ao conceder pontos para o player!");

            if (!$sth->bindParam(":idAccountMoviment", $_SESSION["id_user"], PDO::PARAM_INT))
                throw new Exception("Erro ao conceder pontos para o player!");
            
            if (!$sth->execute())
                throw new Exception("Erro ao conceder pontos para o player!");
                
            $sql = "
                SELECT * FROM account_point
                WHERE idAccount = :idAccount;
            ";

            if (!$sth = $factoryConnection::$conn->prepare($sql))
                throw new Exception("Erro ao checar tabela de pontos!");
            
            if (!$sth->bindParam(":idAccount", $idAccount, PDO::PARAM_INT))
                throw new Exception("Erro ao checar tabela de pontos!");
            
            if (!$sth->execute())
                throw new Exception("Erro ao checar tabela de pontos!");
            
            if ($sth->rowCount() <= 0){

                $sql = "
                    INSERT INTO account_point(
                        idAccount,
                        points
                    )VALUES(
                        :idAccount,
                        :numberPoints
                    );
                ";

            } else {
                $sql = "
                    UPDATE account_point SET
                        points = (points + :numberPoints)
                    WHERE
                        idAccount = :idAccount;
                ";

            }

            if (!$sth = $factoryConnection::$conn->prepare($sql))
                throw new Exception("Erro ao conceder os pontos!");
            
            if (!$sth->bindParam(":idAccount", $idAccount, PDO::PARAM_INT))
                throw new Exception("Erro ao conceder os pontos!");
            
            if (!$sth->bindParam(":numberPoints", $numberPoints, PDO::PARAM_INT))
                throw new Exception("Erro ao conceder os pontos!");
            
            if (!$sth->execute())
                throw new Exception("Erro ao conceder os pontos!");

            $factoryConnection::$conn->commit();

        } catch (Exception $e){

            $factoryConnection::$conn->rollBack();

            throw new Exception($e->getMessage());
        }
    }
}