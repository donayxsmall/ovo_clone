// ignore_for_file: camel_case_types, prefer_typing_uninitialized_variables

import 'package:flutter/material.dart';

class ListTileSecurity extends StatefulWidget {
  const ListTileSecurity({Key? key}) : super(key: key);

  @override
  State<ListTileSecurity> createState() => _ListTileSecurityState();
}

class _ListTileSecurityState extends State<ListTileSecurity> {
  bool _isEnabled = true;
  List profileKeamanan = [
    {
      "title": "Change Security Code",
      "leading": Image.asset(
        'assets/image/profile/security.png',
        alignment: Alignment.center,
      ),
      "trailing": Image.asset('assets/image/profile/arrow_forward.png'),
      "onTap": () {},
      "type": "",
    },
    {
      "title": "Face ID",
      "leading": Image.asset('assets/image/profile/face_id.png',
          alignment: Alignment.centerLeft),
      "trailing": "",
      "onTap": () {},
      "type": "boolean",
    },
  ];

  @override
  Widget build(BuildContext context) {
    return Card(
      child: Padding(
        padding: const EdgeInsets.all(8.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              "Keamanan",
              style: TextStyle(
                fontSize: 16.0,
                fontWeight: FontWeight.bold,
                color: Colors.black,
              ),
            ),
            ListView.builder(
              itemCount: profileKeamanan.length,
              shrinkWrap: true,
              physics: const ScrollPhysics(),
              itemBuilder: (BuildContext context, int index) {
                var item = profileKeamanan[index];
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
                        trailing: item['type'] == 'boolean'
                            ? SizedBox(
                                width: 30,
                                child: Switch(
                                  value: _isEnabled,
                                  onChanged: (value) {
                                    _isEnabled = !_isEnabled;
                                    setState(() {});
                                  },
                                ),
                              )
                            : item['trailing']),
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
