import 'package:flutter/material.dart';
import 'package:ovo_clone/core.dart';

snackbarDanger({required String message, int duration = 4}) {
  var snackBar = SnackBar(
    duration: Duration(seconds: duration),
    backgroundColor: dangerColor,
    content: Text(
      message,
      style: const TextStyle(
        color: Colors.white,
      ),
    ),
  );
  ScaffoldMessenger.of(globalContext).showSnackBar(snackBar);
}

snackbarSuccess({required String message, int duration = 4}) {
  var snackBar = SnackBar(
    duration: Duration(seconds: duration),
    backgroundColor: successColor,
    content: Text(
      message,
      style: const TextStyle(
        color: Colors.white,
      ),
    ),
  );
  ScaffoldMessenger.of(globalContext).showSnackBar(snackBar);
}

snackbarInfo({required String message, int duration = 4}) {
  var snackBar = SnackBar(
    duration: Duration(seconds: duration),
    backgroundColor: infoColor,
    content: Text(
      message,
      style: const TextStyle(
        color: Colors.white,
      ),
    ),
  );
  ScaffoldMessenger.of(globalContext).showSnackBar(snackBar);
}

snackbarWarning({required String message, int duration = 4}) {
  var snackBar = SnackBar(
    duration: Duration(seconds: duration),
    backgroundColor: warningColor,
    content: Text(
      message,
      style: const TextStyle(
        color: Colors.white,
      ),
    ),
  );
  ScaffoldMessenger.of(globalContext).showSnackBar(snackBar);
}
