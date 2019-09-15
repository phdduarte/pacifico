<?php
if(!empty($_POST))
{
    $name = $_POST['name'];

    /*/ this is the email we get from visitors*/
    $domain_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    $redirect_url = 'https://www.pacificocontabilidade.com.br/v1/img/mentiras.pdf';

    /*//-->MUST BE 'https://';*/
    header("Content-type: application/json");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Origin: *.ampproject.org");
    header("AMP-Access-Control-Allow-Source-Origin: ".$domain_url);


    /*/ For Sending Error Use this code /*/
    if(!mail("contato@grazyferreiraemagrecimento.com.br" , "Test submission" , "email: $name <br/> name: $name" , "From: $name\n ")){
        header("HTTP/1.0 412 Precondition Failed", true, 412);

        echo json_encode(array('errmsg'=>'There is some error while sending email!'));
        die();
    }
    else
    {
        /*/--Assuming all validations are good here--*/
        if( empty($redirect_url))
        {
            header("Access-Control-Expose-Headers: AMP-Access-Control-Allow-Source-Origin");
        }
        else
        {
            header("AMP-Redirect-To: ".$redirect_url);
            header("Access-Control-Expose-Headers: AMP-Redirect-To, AMP-Access-Control-Allow-Source-Origin");        }
            echo json_encode(array('successmsg'=>$_POST['name'].'My success message. [It will be displayed shortly(!) if with redirect]'));
        die();
    }
}?>
