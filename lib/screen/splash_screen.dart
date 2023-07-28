// ignore_for_file: camel_case_types, prefer_typing_uninitialized_variables

import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';

class SplashScreen extends StatelessWidget {
  const SplashScreen({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        body: Stack(
      children: [
        SvgPicture.asset(
          'assets/image/background_splash.svg',
          fit: BoxFit.cover,
        ),
        Center(
          child: SvgPicture.asset('assets/image/logo_splash.svg'),
        )
      ],
    ));
  }
}
