import 'package:flutter/material.dart';
import 'package:intl/date_symbol_data_local.dart';
import 'package:ovo_clone/core.dart';
import 'package:ovo_clone/setup.dart';

void main() async {
  await initialize();
  initializeDateFormatting('id');
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    return MaterialApp.router(
      debugShowCheckedModeBanner: false,
      routerConfig: goRouter,
      // routeInformationParser: goRouter.routeInformationParser,
      // routerDelegate: goRouter.routerDelegate,
      // routeInformationProvider: goRouter.routeInformationProvider,
      title: 'OVO',
      // navigatorKey: Get.navigatorKey,
      theme: getDefaultTheme(),
      // home: const SplashScreen(),
    );
  }
}
