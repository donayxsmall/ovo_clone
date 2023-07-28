import 'package:flutter/material.dart';

class ListProfile {
  static List profileAkun = [
    {
      "title": "OVO Premier",
      "leading": Image.asset('assets/image/profile/ovo_premier.png'),
      "trailing": Image.asset('assets/image/profile/arrow_forward.png'),
      "onTap": () {},
    },
    {
      "title": "OVO Points",
      "leading": Image.asset('assets/image/profile/ovo_point.png'),
      "trailing": Image.asset('assets/image/profile/arrow_forward.png'),
      "onTap": () {},
    },
    {
      "title": "OVO Stamp",
      "leading": Image.asset('assets/image/profile/ovo_stamp.png'),
      "trailing": Image.asset('assets/image/profile/arrow_forward.png'),
      "onTap": () {},
    }
  ];

  static List profileBantuan = [
    {
      "title": "Help Center",
      "leading": Image.asset('assets/image/profile/help_center.png'),
      "trailing": Image.asset('assets/image/profile/arrow_forward.png'),
      "onTap": () {},
    },
  ];

  static List profileKeamanan = [
    {
      "title": "Change Security Code",
      "leading": Image.asset(
        'assets/image/profile/security.png',
        alignment: Alignment.center,
      ),
      "trailing": Image.asset('assets/image/profile/arrow_forward.png'),
      "onTap": () {},
    },
    {
      "title": "Face ID",
      "leading": Image.asset('assets/image/profile/face_id.png',
          alignment: Alignment.centerLeft),
      "trailing": Switch(
        value: true,
        onChanged: (value) {},
      ),
      "onTap": () {},
    },
  ];
}
