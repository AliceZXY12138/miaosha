<?php
namespace lib;
use Firebase\JWT\JWT;
 
class Jwttoken
{
    //生成token
    public function createJwt($username)
    {
        $key    = md5('nobita'); //jwt的签发密钥，验证token的时候需要用到
        $time   = time();
        $expire = $time + 300; //过期时间
        $token  = array(
            "username" => $username,
            "iss"      => "",//签发组织
            "aud"      => "", //签发作者
            "iat"      => $time, //签发时间
            "nbf"      => $time, //生效时间
            "exp"      => $expire
        );
        $jwt    = JWT::encode($token, $key);
        return $jwt;
    }
 
 
    //校验jwt权限API
    public function verifyJwt($jwt)
    {
        $key = md5('nobita');
        try {
            $jwtAuth  = json_encode(JWT::decode($jwt, $key, array('HS256')));
            $authInfo = json_decode($jwtAuth, true);
            $msg      = [];
            if (!empty($authInfo['username'])) {
                $msg = [
                    'status'   => 0,
                    'msg'      => 'Token验证通过',
                    'username' => $authInfo['username']
                ];
            } else {
                //Token验证不通过,用户不存在
                $msg = [
                    'status' => 10001,
                    'msg'    => '当前用户不存在'
                ];
            }
            return json_encode($msg);
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            echo json_encode([
                'status' => 10002,
                'msg'    => 'Token无效'
            ]);
            exit;
        } catch (\Firebase\JWT\ExpiredException $e) {
            //Token过期
            echo json_encode([
                'status' => 10003,
                'msg'    => '登录信息已超时，请重新登录'
            ]);
            exit;
        } catch (Exception $e) {
            echo json_encode([
                'status' => 10004,
                'msg'    => '未知错误'
            ]);
            exit;
        }
    }
}

