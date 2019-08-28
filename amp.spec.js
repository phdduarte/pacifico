'use strict';
var amphtmlValidator = require('amphtml-validator');
var fs = require('fs');

amphtmlValidator.getInstance().then(function (validator) {
  var input = fs.readFileSync('public/index.html', 'utf8');
  var result = validator.validateString(input);
  //((result.status === 'PASS') ? console.log : console.error)(result.status);
  if (result.status === 'PASS') {
    console.log(result.status);
    process.exit(0);
  } else {
    for (var ii = 0; ii < result.errors.length; ii++) {
      var error = result.errors[ii];
      var msg = 'line ' + error.line + ', col ' + error.col + ': ' + error.message;
      if (error.specUrl !== null) {
        msg += ' (see ' + error.specUrl + ')';
      }
      ((error.severity === 'ERROR') ? console.error : console.warn)(msg);
    }

    process.exit(1);
  }
});
