<?php
//session_start();
//if(!isset($_SESSION['user'])) { header("Location: /login");}
$id=$_SESSION['user']['id'];
require 'model/GetBase.php';
if(!isset($_GET['page']))
{
    $_GET['page']=1;
}
if(!isset($_GET['type']))
{
    $_GET['type']='advice';
}
$base = new GetBase();
//require 'path/header.php';
$query = "SELECT COUNT(*) from forum";
$res = $base->Query_try($query);
$res = mysqli_fetch_array($res);
$amount = $res[0];
$type = $_GET['type'];

$mes = $base->GetSomeMessages($_GET['page'], $type);

?>
<style>
    .user-av
    {
        max-width: 100%;
    }
    .body{
        border-left: 2px solid white;
    }
    .attachments
    {
        max-height: 100px;
        transition: 1s;
    }
    .attachments:hover
    {
        transform: scale(5) translateX(100px) translateY(-20px);
    }
    .tab
    {
        display: table-cell;
    }
    .row.tab
    {
        display: table;
    }
    .pagination {
        width:100%;
        text-align:center;
        padding: 10px;
        margin:10px auto;
        border: 1px solid #ddd;
    }
    .pagination ul{
        width:100%;
        padding:0px;
        margin:0px;
    }
    .pagination ul li {
        display:inline-block;
        list-style:none;
        margin:5px 5px;
        font-size:14px;
        text-align:center;
    }
    .pagination ul li a, .pagination ul li a:visited {
        display:block;
        text-decoration:none;
        color: black;
        background: repeat-x scroll 0 0 gold;

        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        border-radius: 50%;

        height: 28px;
        width: 28px;
        line-height: 26px;
        top: -1px;

    }
    a{
        text-decoration: none;
        color: white;
        font-size: 20px;
    }
    a:hover
    {
        color: gold;
        cursor: pointer;
    }
    .content
    {
        margin-top: 110px
    }

</style>
<div class="container forum-card content">
    <div class="row">
        <div class="col-sm-3">
            <a href="?type=tech&page=1">Технические вопросы</a>
        </div>
        <div class="col-sm-7">
            <a href="?type=advice&page=1">Предложения</a>
        </div>
        <div class="col-sm-2 text-right">
            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#userModal">Новое сообщение</button>
        </div>

    </div>
</div>

<?php $j=1; foreach($mes as $row): ?>
<div class="container forum-card message-body">
    <div class="row message">
        <div class="col-sm-1 user  text-center">
            <div class="user-av">
                <a href="profile.php?id=<?=$row['id_e']?>" ><img src="uploads\<?=$row['avatar']?>" class="user-av"></a>
                <p><?=$row['name']?></p>
            </div>
        </div>
        <div class="col body text-left">

            <div class="row tab">
                <div class="text-left tab text-small text-secondary"><?=$row['date_o']?></div><div class="text-right tab">#<?=$j?></div>
            </div>
            <h2><?=$row['re_m']?></h2>
            <p><?=$row['text_m']?></p>
            <?php if(isset($row['attachments'])): ?>
                <img src="uploads\messages\<?=$row['attachments']?>" class="attachments">
            <?php endif; ?>
        </div>
    </div>

</div>
<?php ++$j; endforeach; ?>


<div class="container text-center">
    <div class="pagination">
        <ul>
            <?php for($i=1; $i<$amount/10+1; $i++):?>
            <li><a href="?type=<?=$type?>&page=<?=$i?>" title="Страница <?=$i?>"><?=$i?></a></li>
            <?php endfor; ?>
        </ul>
    </div>
</div>

    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Новое сообщение</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <form action="controller/UserFormController.php?type=feedback" class="new"method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="theme" class="form-label" id="re">Тема сообщения</label>
                            <input type="text" aria-label="Тема сообщения" name="re"class="form-control" id="theme">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label" id="text">Пример текстового поля</label>
                            <textarea class="form-control" name="text" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Прикрепите фото</label>
                                <input class="form-control" name="atatch" type="file" id="formFile">
                            </div>
                    <input type="hidden" name="id"value="<?=$_SESSION['user']['id']?>">
                            <input type="hidden" name="type" value="<?=$_GET['type']?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Отправить</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<?php
?>