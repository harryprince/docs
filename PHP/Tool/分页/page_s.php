<?php
$p = $_GET['p'];

$conn = @mysql_connect('mysql420.db.sakura.ne.jp',"marukashi-center","y9newz2yn4") || die("���������Ӵ���");

mysql_select_db("marukashi-center_heiwa");

$sql = "select * from phbdc_history";


$result = mysql_query($sql);	//��Դ���

//1.��ȡ�ܼ�¼��

$rowsTotal = mysql_num_rows($result);

//2.ָ��ÿҳ��ʾ�ļ�¼��

$pageSize = 20;

//3.��ȡ��ҳ��

$pageTotal = ceil($rowsTotal / $pageSize);


//���ηǷ�ҳ��
if($p == '' || $p < 1) $p = 1;

if(!is_numeric($p)) $p = 1;

if($p >= $pageTotal) $p = $pageTotal;

$p = (int)$p;



//4.����ƫ��ֵ

$offset = ($p - 1) * $pageSize;

$sql .=  " limit {$offset},{$pageSize}";


$result = mysql_query($sql);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ƽ�Ͳ��Ӯb | �����ߌ���HOME</title>
<link rel="stylesheet" type="text/css" href="../share/css/style.css" />
<script type="text/javascript" src="../share/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../share/js/script.js"></script>
</head>
<style type="text/css"> 
table{
border:1px solid #696867;
width:747px;
margin-top:20px;
}
th { 
border:1px solid #696867;
background: #999998; 
font-size:11px; 
padding: 6px 6px 6px 12px; 
color: #3c3b3b; 
} 

td { 
border:1px solid #696867;
background: #fff; 
font-size:11px; 
padding: 6px 6px 6px 12px; 
color: #3c3b3b; 
text-align:center;
} 
</style>
<body class="admin_index">
<div id="main">
<div id="header">
<a href="./" class="logo"><img src="../share/images/logo_admin.png" alt="" /></a>
</div>
<div id="middle">
<div id="left-column">
<h3>����ǩ`������</h3>
<ul class="nav">
<li><a href="../buildreg">�U�J������ε��h</a></li>
<li><a href="../rentreg">�U�J�����أ��ε��h</a></li>
<li><a href="../list">�U�J�������һ�E</a></li>
<li><a href="../share/php/csvexportbuilding.php">CSV�ǩ`����������</a></li>
<li><a href="../list2">�U�J�����أ���һ�E</a></li>
<li><a href="../share/php/csvexportrent.php">CSV�ǩ`����������</a></li>
</ul>

<h3>�˥�`������</h3>
<ul class="nav">
<li><a href="../newadd">�˥�`�����h</a></li>
<li><a href="../newlist">�˥�`��һ�E</a></li>
</ul>


<h3>���ޥ����h</h3>
<ul class="nav">
<li><a href="../../public/mail/index.php?s=Index/mailcsv">CSV�ǩ`����������</a></li>
</ul>
</div>

<div id="center-column">
<div class="top-bar">
<h1>�����ߌ���HOME</h1>
</div><br />

<p>�����������뤿��ι����ߌ��å����ȤǤ���<br />
��ӛ��˥�`���饢���������Ƥ���������</p>
<table cellspacing="0"> 
<caption> </caption> 
<tr> 
<th scope="col">id</th> 
<th scope="col">page:1.���� 2.����</th> 
<th scope="col">action:1.����2.����3.ɾ��</th> 
<th scope="col">time</th> 
</tr> 
<?php while($row = mysql_fetch_assoc($result)) {?>
<tr> 
<td class="row"><?php echo $row['id']?></td> 
<td class="row">
	<?php 
		if($row['page']==1){
			echo '����';
		}elseif($row['page']==2){
			echo '����';
		}
	?>
</td> 
<td class="row">
	<?php 
		if($row['action']==1){
			echo '��Ҏ';
		}elseif($row['action']==2){
			echo '����';
		}elseif($row['action']==3){
			echo '����';
		}
	?>
</td> 
<td class="row"><?php echo $row['time']?>1</td> 
</tr> 
<?php }?>
<tr>
    <td colspan="4">
    <?php
   	if($pageTotal == 1){
		echo("first&nbsp;&nbsp;prev&nbsp;&nbsp;next&nbsp;&nbsp;last");
	} else {
		if($p == 1){
			echo("first&nbsp;&nbsp;prev&nbsp;&nbsp;");
			echo("<a href=\"index.php?p=".($p+1)."\">next</a>&nbsp;&nbsp;");
			echo("<a href=\"index.php?p={$pageTotal}\">last</a>");
		}
		
		if($p == $pageTotal){
			echo("<a href=\"index.php?p=1\">first</a>&nbsp;&nbsp;");
			echo("<a href=\"index.php?p=".($p-1)."\">prev</a>&nbsp;&nbsp;");
			echo("next&nbsp;&nbsp;last");
		}
		
		if($p > 1 && $p < $pageTotal){
			echo("<a href=\"index.php?p=1\">first</a>&nbsp;&nbsp;");
			echo("<a href=\"index.php?p=".($p-1)."\">prev</a>&nbsp;&nbsp;");
			echo("<a href=\"index.php?p=".($p+1)."\">next</a>&nbsp;&nbsp;");
			echo("<a href=\"index.php?p={$pageTotal}\">last</a>");
		}
	}
	?>
    </td>
  </tr>
</table> 

</div>
</div>
<div id="footer"></div>
</div>



</body>
</html>

