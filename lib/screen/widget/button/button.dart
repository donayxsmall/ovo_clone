// ignore_for_file: camel_case_types, prefer_typing_uninitialized_variables

import 'package:flutter/material.dart';

import 'package:ovo_clone/shared/theme/theme_config.dart';

class XButton extends StatelessWidget {
  const XButton({
    Key? key,
    required this.label,
    required this.onPressed,
  }) : super(key: key);

  final String label;
  final Function() onPressed;

  @override
  Widget build(BuildContext context) {
    return Center(
      child: SizedBox(
        width: 249,
        height: 43,
        child: ElevatedButton(
          style: ElevatedButton.styleFrom(
              backgroundColor: primaryColor,
              shape: const RoundedRectangleBorder(
                borderRadius: BorderRadius.all(
                  Radius.circular(10.0),
                ),
              )),
          onPressed: onPressed,
          child: Text(label),
        ),
      ),
    );
  }
}
