// ignore_for_file: camel_case_types, prefer_typing_uninitialized_variables

import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:go_router/go_router.dart';

class SplashScreen extends StatefulWidget {
  const SplashScreen({Key? key}) : super(key: key);

  @override
  State<SplashScreen> createState() => _SplashScreenState();
}

class _SplashScreenState extends State<SplashScreen> {
  @override
  Widget build(BuildContext context) {
    Future.delayed(
      const Duration(seconds: 2),
      () => context.goNamed('login'),
      // () => Get.offAll(const LoginScreen()),
    );
    return Scaffold(
        body: Stack(
      children: [
        SizedBox(
          width: MediaQuery.of(context).size.width,
          child: SvgPicture.asset(
            'assets/image/background_splash.svg',
            fit: BoxFit.cover,
          ),
        ),
        Center(
          child: SvgPicture.asset('assets/image/logo_splash.svg'),
        )
      ],
    ));
  }
}
