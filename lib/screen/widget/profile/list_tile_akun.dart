// ignore_for_file: camel_case_types, prefer_typing_uninitialized_variables

import 'package:flutter/material.dart';

class ListTileAkun extends StatelessWidget {
  const ListTileAkun({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    List profileAkun = [
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

    return Card(
      child: Padding(
        padding: const EdgeInsets.all(8.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              "Akun",
              style: TextStyle(
                fontSize: 16.0,
                fontWeight: FontWeight.bold,
                color: Colors.black,
              ),
            ),
            const SizedBox(
              height: 10.0,
            ),
            ListView.builder(
              itemCount: profileAkun.length,
              shrinkWrap: true,
              physics: const ScrollPhysics(),
              itemBuilder: (BuildContext context, int index) {
                var item = profileAkun[index];
                return Column(
                  children: [
                    ListTile(
                      leading: item['leading'],
                      title: Text(
                        "${item['title']}",
                        style: const TextStyle(
                          fontSize: 14.0,
                          fontWeight: FontWeight.bold,
                          color: Colors.black,
                        ),
                      ),
                      trailing: item['trailing'],
                    ),
                    const SizedBox(
                      height: 2.0,
                    ),
                    const Divider(),
                  ],
                );
              },
            ),
          ],
        ),
      ),
    );
  }
}
