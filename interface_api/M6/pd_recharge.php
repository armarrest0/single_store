<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
<head>
    <title></title>
    <link href="../list.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div>
        <table width="99%" border="0" cellpadding="0" cellspacing="0" class="borders">
            <tr class="addtop">
                <td style='font-weight: bolder; height: 25px; text-align: center; font-size: 14px;'
                    colspan='2'>m6充值
                </td>
            </tr>
            <tr>
                <td style='height: 25px; width: 75px;' class='tdbgleft'>请求方式
                </td>
                <td>POST
                </td>
            </tr>
            <tr>
                <td style='height: 25px; width: 75px;' class='tdbgleft'>url地址
                </td>
                <td><span id="url_text"></span>
                </td>
            </tr>
            <tr>
                <td style='height: 25px;' class='tdbgleft'>参数
                </td>
                <td style='line-height: 25px;'>   
                    {
code: 200,
datas: {
recharge_list: [
100,
200,
500,
1000
]
}
}
                </td>
            </tr>
            
             <tr>
                <td style='height: 25px; width: 75px;' class='tdbgleft'>测试
                </td>
                <td>
                    <form  id = "form1"   name = "form1"   method = "post" target="_self">       
            
                        <input type="submit" value="提交" onClick="subform();"/>
                    </form>
                </td>
            </tr>
            
            <tr>
                <td style='height: 25px;' class='tdbgleft'>返回参数
                </td>
                <td style='line-height: 25px;'>
                     <pre style="word-wrap: break-word; white-space: pre-wrap; font-size: 12px; color: #222222;">


                     </pre>
                </td>

            </tr>
        </table>
    </div>
</body>

<script language="JavaScript" > 

document.getElementById("url_text").innerText = "http://"+window.location.host+"/mobile/index.php?act=m6_interface&op=recharge"; 

function subform(){ 
document.form1.action="http://"+window.location.host+"/mobile/index.php?act=m6_interface&op=recharge";  
form1.submit(); 
} 
</script> 

</html>