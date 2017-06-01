require('dotenv').config({path: __dirname + '/../.env'});

var OTPAuth = require('otpauth');
var nightmare = require('nightmare')({ show: true });
var totp = new OTPAuth.TOTP({
  issuer: 'MaiCoin',
  secret: OTPAuth.Secret.fromB32(process.env.MAICOIN_OTP_SECRET),
  digits: 6
});

var price = parseFloat(process.argv[2]);

if (price) {
  nightmare
    .goto('https://www.maicoin.com/zh-TW/sell/eth-twd')
    .type('#user_email', process.env.MAICOIN_USER_EMAIL)
    .type('#user_password', process.env.MAICOIN_USER_PASS)
    .click('#loginForm .btn')
    .wait('#sell_coin_field')
    .type('#sell_coin_field', price)
    .click('#sell_submit')
    .wait(5000)
    .end()
    .then(function(result) {
      console.log(result);
    });
}
