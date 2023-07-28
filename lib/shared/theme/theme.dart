import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:ovo_clone/shared/theme/theme_config.dart';

ThemeData getDefaultTheme() {
  return ThemeData().copyWith(
    primaryColor: Colors.white,
    bottomNavigationBarTheme: BottomNavigationBarThemeData(
      unselectedItemColor: const Color(0xff909090),
      selectedItemColor: primaryColor,
    ),
    textTheme: TextTheme(
      titleSmall: GoogleFonts.poppins(
        color: primaryColor,
      ),
      titleMedium: GoogleFonts.poppins(
        color: primaryColor,
        fontSize: 15.0,
      ),
      titleLarge: GoogleFonts.poppins(
        color: primaryColor,
      ),
      bodySmall: GoogleFonts.poppins(
        color: primaryColor,
      ),
      bodyMedium: GoogleFonts.poppins(
        color: primaryColor,
      ),
      bodyLarge: GoogleFonts.poppins(
        color: primaryColor,
      ),
    ),
  );
}
