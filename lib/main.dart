import 'package:flutter/material.dart';
import 'package:intl/date_symbol_data_local.dart';
import 'package:ovo_clone/core.dart';

void main() {
  initializeDateFormatting('id');
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Flutter Demo',
      navigatorKey: Get.navigatorKey,
      theme: getDefaultTheme(),
      home: const MainNavigationScreen(),
    );
  }
}
