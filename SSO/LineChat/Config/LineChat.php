<?php

namespace SSO\LineChat\Config;
class LineChat
{
    CONST CLIENT_ID = '2001695985';
    CONST CLIENT_SECRET = 'a0c390b91fe51d4597341442ed3c987a';
    CONST GRANT_TYPE = 'authorization_code';
    CONST ACCESS_TOKEN = 'access_token';
    CONST LINE_ACCOUNT_NAME = 'displayName';
    CONST BASE_URL_REQ_TOKEN = 'https://api.line.me/oauth2/v2.1/token';
    CONST BASE_URL_PROFILE_ACCESS_TOKEN = 'https://api.line.me/v2/profile';
    CONST BASE_URL_AUTHENTICATION = 'https://access.line.me/oauth2/v2.1/authorize?';
    CONST BASE_URL_PROFILE_TOKEN_ID = 'https://api.line.me/oauth2/v2.1/verify';
    CONST CALL_BACK_URL_ENDPOINT = 'sso_linechat/reqtoken/lineauthcontroller';
    CONST RESPONSE_OK = 200;
    CONST ID_TOKEN = 'id_token';
    CONST SCOPE = 'profile%20openid%20email';
}
