<?php


include "./jwt/JWT.php";
include "./koneksi.php";

use Firebase\JWT\JWT;

class Auth_model extends Koneksi
{
    protected $table = "auth_user";

    public function register($username, $password)
    {
        $password = htmlspecialchars($password);
        mysqli_query($this->koneksi, "INSERT INTO {$this->table}(`username`, `password`) VALUES('{$username}', '{$password}')");

        if (mysqli_affected_rows($this->koneksi)) {
            $output = [
                "metadata" => [
                    "message" => "Ok",
                    "username" => $username,
                    "password" => $password,
                    "code" => 200
                ]
            ];
            http_response_code(200);
            echo json_encode($output);
            return;
        } else {
            $output = [
                "metadata" => [
                    "message" => "Registration Failed",
                    "code" => 400
                ]
            ];
            http_response_code(400);
            echo json_encode($output);
            return;
        }
    }

    public function privateKey()
    {
        $privateKey = "
            MIICXAIBAAKBgQC8kGa1pSjbSYZVebtTRBLxBz5H4i2p/llLCrEeQhta5kaQu/Rn
            vuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t0tyazyZ8JXw+KgXTxldMPEL9
            5+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4ehde/zUxo6UvS7UrBQIDAQAB
            AoGAb/MXV46XxCFRxNuB8LyAtmLDgi/xRnTAlMHjSACddwkyKem8//8eZtw9fzxz
            bWZ/1/doQOuHBGYZU8aDzzj59FZ78dyzNFoF91hbvZKkg+6wGyd/LrGVEB+Xre0J
            Nil0GReM2AHDNZUYRv+HYJPIOrB0CRczLQsgFJ8K6aAD6F0CQQDzbpjYdx10qgK1
            cP59UHiHjPZYC0loEsk7s+hUmT3QHerAQJMZWC11Qrn2N+ybwwNblDKv+s5qgMQ5
            5tNoQ9IfAkEAxkyffU6ythpg/H0Ixe1I2rd0GbF05biIzO/i77Det3n4YsJVlDck
            ZkcvY3SK2iRIL4c9yY6hlIhs+K9wXTtGWwJBAO9Dskl48mO7woPR9uD22jDpNSwe
            k90OMepTjzSvlhjbfuPN1IdhqvSJTDychRwn1kIJ7LQZgQ8fVz9OCFZ/6qMCQGOb
            qaGwHmUK6xzpUbbacnYrIM6nLSkXgOAwv7XXCojvY614ILTK3iXiLBOxPu5Eu13k
            eUz9sHyD6vkgZzjtxXECQAkp4Xerf5TGfQXGXhxIX52yH+N2LtujCdkQZjXAsGdm
            B2zNzvrlgRmgBrklMTrMYgm1NPcW+bRLGcwgW2PTvNM=
            ";
        return $privateKey;
    }

    public function validateUser($username, $password)
    {
        $username = mysqli_escape_string($this->koneksi, $username);
        $query = mysqli_query($this->koneksi, "SELECT * FROM " . $this->table . " WHERE username = '" .$username . "' AND aktif = 1");
        $data = mysqli_fetch_assoc($query);

        if(mysqli_num_rows($query)){
            if ($password == $data['password']) {
                $secret_key = $this->privateKey();
                $issuer_claim = "THE_ISSUER";
                $audience_claim = "THE_AUDIENCE";
                $issuedat_claim = time();
                // $notbefore_claim = $issuedat_claim + 10;
                $expire_claim = $issuedat_claim + $data['expired']; // 3600 - 1 jam | 60 - 1 menit
                $token = array(
                    "iss" => $issuer_claim,
                    "aud" => $audience_claim,
                    "iat" => $issuedat_claim,
                    // "nbf" => $notbefore_claim,
                    "exp" => $expire_claim,
                    "data" => array(
                        "id" => $data['id'],
                        "username" => $data['username']
                    )
                );
                $token = JWT::encode($token, $secret_key);
    
                $output = [
                    "response" => [
                        "token" => $token
                    ],
                    "metadata" => [
                        "message" => "Ok",
                        "code" => 200
                    ]
                ];
                return $output;
            } else {
                $output = [
                    "metadata" => [
                        "message" => "Authentication failed",
                        "code" => 401
                    ]
                ];
                return $output;
            }
        }else{
            $output = [
                "metadata" => [
                    "message" => "Authentication failed",
                    "code" => 401
                ]
            ];
            return $output;
        }
    }

    public function isValidToken(){
        header("Access-Control-Allow-Origin: * ");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        
        // https://stackoverflow.com/a/541463 - READ HEADERS
        
        // Example : $_SERVER['HTTP_XXXXXX_XXXXXX']
        // Replace XXXXXX_XXXX with the name of the header you need in UPPERCASE (and with '-' replaced by '_') 


        if(!isset($_SERVER['HTTP_X_TOKEN'])){
            return -2;
        }

        $secret_key = $this->privateKey();
        $token = $_SERVER['HTTP_X_TOKEN'];
        
        if ($token) {
            try {
                $decoded = JWT::decode($token, $secret_key, array('HS256'));
                if ($decoded) {
                    return 1;
                }
            } catch (\Exception $e) {
                if($e->getMessage() == "Expired token"){
                    return -1;
                }
                return 0;
            }
        }
        return 0;
    }
}