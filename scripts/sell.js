require('dotenv').config({path: __dirname + '/../.env'});

// var OTPAuth = require('otpauth');
// var totp = new OTPAuth.TOTP({
//   issuer: 'Bitoex',
//   secret: OTPAuth.Secret.fromB32(process.env.MAICOIN_OTP_SECRET),
//   digits: 6
// });

var nightmare = require('nightmare')({ show: true });
var type = process.argv[2].toLowerCase();
var price = parseFloat(process.argv[3]);

if (price && type) {
  nightmare
    .goto(`https://www.maicoin.com/zh-TW/sell/${type}-twd`)
    .type('#user_email', process.env.MAICOIN_USER_EMAIL)
    .type('#user_password', process.env.MAICOIN_USER_PASS)
    .click('#loginForm .btn')
    .wait(1000)
    .wait('#sell_coin_field')
    .type('#sell_coin_field', price)
    .click('#sell_submit')
    .wait(1000)
    .click('#sell_agreement_1')
    .click('#sell_agreement_2')
    .click('#submit_sell_modal')
    .wait(3000)
    .end()
    .then();
}
