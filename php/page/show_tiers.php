<?php
require_once "./php/db_connect.php";
$tiers = null; # ассоциативный массив с данными об уровнях проекта

function getTiers() {
    global $tiers;
    $response = "<ul class='tiers-list'>";
    try {
        $DBH = connectDataBase();
        if (isset($_GET['name'])) {
            $STH = $DBH->prepare("SELECT `trs`.* FROM `projects_tiers` AS `trs` 
            INNER JOIN `projects` AS `prj` ON `prj`.`idProject` = `trs`.`project`
            WHERE `prj`.`name` = '{$_GET['name']}'");
        } else {
            $STH = $DBH->prepare("SELECT `trs`.* FROM `projects_tiers` AS `trs` 
            INNER JOIN `projects` AS `prj` ON `prj`.`idProject` = `trs`.`project`
            WHERE `prj`.`author` = '{$_SESSION['id']}'");
        }
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $STH->setFetchMode(PDO::FETCH_ASSOC);  # устанавливаем режим выборки
            $cnt = 0;
            $SSTH = $DBH->prepare("SELECT `sbs`.idTier FROM `subscriptions` AS `sbs` 
            INNER JOIN `projects` AS `prj` ON `prj`.`idProject` = `sbs`.`idProject`
            WHERE `sbs`.`idU` = '{$_SESSION['id']}'");
            $SSTH->execute();
            if ($SSTH->rowCount() > 0) {
                $result = $SSTH->fetch(PDO::FETCH_ASSOC);
                $user_sub = $result['idTier'];
            }
            while($tier = $STH->fetch()) {
                $response .= "<li class='tl__tier'>"."<h3>{$tier['title']}</h3>"."<span class='description'>{$tier['description']}</span>";
                (intval($tier['limit']) > 0) ? $response .= "<span class='limit'>Доступно: {$tier['limit']}</span>" : false;
                ($cnt > 0) ? $response .= "<span class='all-above'>Всё вышеперечисленное +</span>" : false;
                $response .= "<ul class='benefits-list'>";
                if ($_GET['name']) {
                    $SSTH = $DBH->prepare("SELECT `bnf`.* FROM `project_benefits` AS `bnf` 
                    INNER JOIN `projects` AS `prj` ON `prj`.`idProject` = `bnf`.`project`
                    INNER JOIN `projects_tiers` pt on bnf.tier = pt.idTier
                    WHERE `prj`.`name` = '{$_GET['name']}' AND pt.idTier = '{$tier['idTier']}'");
                } else {
                    $SSTH = $DBH->prepare("SELECT `bnf`.* FROM `project_benefits` AS `bnf` 
                    INNER JOIN `projects` AS `prj` ON `prj`.`idProject` = `bnf`.`project`
                    INNER JOIN `projects_tiers` pt on bnf.tier = pt.idTier
                    WHERE `prj`.`author` = '{$_SESSION['id']}' AND pt.idTier = '{$tier['idTier']}'");
                }
                $SSTH->execute();
                if ($SSTH->rowCount() > 0) {
                    $SSTH->setFetchMode(PDO::FETCH_ASSOC);
                    while ($benefit = $SSTH->fetch()) {
                        $response .= "<li class='bl__benefit'>{$benefit['content']}</li>";
                    }
                } else {
                    exit("Нет преимуществ");
                }
                $response .= "</ul>";
                $disable = '';
                if (isset($_GET['name'])) {
                    if (isset($user_sub)) {
                        if ($user_sub == $tier['idTier']) {
                            $btn_text = "Вы подписаны";
                            $disable = "disabled='disabled'";
                        } else {
                            $btn_text = "Поддержать за {$tier['price']}₽";
                        }
                    } else {
                        $btn_text = "Поддержать за {$tier['price']}₽";
                    }
                    $response .= "<button class='join pulse pulse-button' {$disable} data-tier='{$tier['idTier']}'>{$btn_text}</button>" . "</li>";
                } else {
                    $response .= "<span class='price'>{$tier['price']} рублей</span>" . "</li>";
                }
                $cnt++;
            }
        }
        else
            return;
    }
    catch (PDOException $e) { echo $e->getMessage(); }
    $response .= "</ul>";
    echo $response;
}


//<ul class="tiers-list">
//    <li class="tl__tier">
//        <h3>Лёгкое увлечение</h3>
//        <span class="price">50 рублей</span>
//        <ul class="benefits-list">
//            <li class="bl__benefit">Ранний доступ к фото</li>
//        </ul>
//    </li>
//    <li class="tl__tier">
//        <h3>Настоящий фанат</h3>
//        <span class="price">200 рублей</span>
//        <span class="all-above">Всё вышеперечисленное +</span>
//        <ul class="benefits-list">
//            <li class="bl__benefit">Неудачные снимки</li>
//        </ul>
//    </li>
//    <li class="tl__tier">
//        <h3>Больше чем любовь</h3>
//        <span class="price">500 рублей</span>
//        <span class="all-above">Всё вышеперечисленное + </span>
//        <ul class="benefits-list">
//            <li class="bl__benefit">Сигна с попужкой раз в месяц</li>
//            <li class="bl__benefit">Секретные видеоматериалы</li>
//        </ul>
//        <span class="description">Ты станешь для меня лучшим другом</span>
//    </li>
//</ul>