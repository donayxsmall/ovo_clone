// ignore_for_file: camel_case_types, prefer_typing_uninitialized_variables

import 'package:flutter/material.dart';
import 'package:ovo_clone/core.dart';

class ProfileScreen extends StatefulWidget {
  const ProfileScreen({Key? key}) : super(key: key);

  @override
  State<ProfileScreen> createState() => _ProfileScreenState();
}

class _ProfileScreenState extends State<ProfileScreen> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SafeArea(
        child: Stack(
          children: [
            Container(
              height: MediaQuery.of(context).size.height * 0.23,
              decoration: const BoxDecoration(
                image: DecorationImage(
                  image: AssetImage('assets/image/head_background_profile.png'),
                  fit: BoxFit.fill,
                ),
              ),
            ),
            Container(
              margin: const EdgeInsets.only(left: 20, right: 20, top: 42),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  const Text(
                    "Profile",
                    style: TextStyle(
                      fontSize: 30.0,
                      fontWeight: FontWeight.bold,
                      color: Colors.white,
                    ),
                  ),
                  const SizedBox(
                    height: 10.0,
                  ),
                  Card(
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(10.0),
                    ),
                    child: Row(
                      children: [
                        const Padding(
                          padding: EdgeInsets.all(10.0),
                          child: Row(
                            mainAxisAlignment: MainAxisAlignment.spaceBetween,
                            children: [
                              CircleAvatar(
                                backgroundImage: NetworkImage(
                                  "https://i.ibb.co/PGv8ZzG/me.jpg",
                                ),
                              ),
                              SizedBox(
                                width: 20.0,
                              ),
                              Column(
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Text(
                                    "Donny Kusdianto",
                                    style: TextStyle(
                                      fontSize: 12.0,
                                      fontWeight: FontWeight.bold,
                                      color: Color(0xff594C78),
                                      letterSpacing: 12 * 0.02,
                                    ),
                                  ),
                                  Text(
                                    "0895-7663-6036",
                                    style: TextStyle(
                                      fontSize: 12.0,
                                      color: Color(0xff594C78),
                                      letterSpacing: 12 * 0.02,
                                    ),
                                  ),
                                ],
                              ),
                            ],
                          ),
                        ),
                        const Spacer(),
                        Container(
                          width: 0.1,
                          height: 60,
                          decoration: BoxDecoration(
                            color: Colors.black,
                            boxShadow: [
                              BoxShadow(
                                color: Colors.grey.withOpacity(0.5),
                                spreadRadius: 0.5,
                                blurRadius: 2,
                                offset: const Offset(
                                    0, 3), // atur offset agar terlihat bayangan
                              ),
                            ],
                          ),
                        ),
                        Row(
                          children: [
                            Container(
                              padding: const EdgeInsets.all(10.0),
                              child: const Text(
                                "Ubah",
                                style: TextStyle(
                                  fontSize: 12.0,
                                  fontWeight: FontWeight.bold,
                                  color: Color(0xff146C94),
                                ),
                              ),
                            ),
                          ],
                        ),
                      ],
                    ),
                  ),
                  const SizedBox(
                    height: 15.0,
                  ),
                  Card(
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(10.0),
                    ),
                    child: Padding(
                      padding: const EdgeInsets.all(13.0),
                      child: Row(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          Image.asset('assets/image/barcode.png'),
                          const SizedBox(
                            width: 10.0,
                          ),
                          const Text(
                            "Loyalty Barcode",
                            style: TextStyle(
                              fontSize: 16.0,
                              fontWeight: FontWeight.bold,
                              color: Colors.black,
                            ),
                          ),
                        ],
                      ),
                    ),
                  ),
                  const SizedBox(
                    height: 10.0,
                  ),
                  Expanded(
                    child: SingleChildScrollView(
                      physics: const ClampingScrollPhysics(),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          const ListTileAkun(),
                          const SizedBox(
                            height: 10.0,
                          ),
                          const ListTileHelp(),
                          const SizedBox(
                            height: 10.0,
                          ),
                          const ListTileSecurity(),
                          const SizedBox(
                            height: 15.0,
                          ),
                          SizedBox(
                            width: MediaQuery.of(context).size.width,
                            height: 35,
                            child: ElevatedButton(
                              style: ElevatedButton.styleFrom(
                                  backgroundColor: primaryColor,
                                  shape: RoundedRectangleBorder(
                                      borderRadius: BorderRadius.circular(20))),
                              onPressed: () {},
                              child: const Text("Sign Out",
                                  style: TextStyle(
                                    color: Colors.white,
                                  )),
                            ),
                          ),
                          const SizedBox(
                            height: 30.0,
                          ),
                        ],
                      ),
                    ),
                  )
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}
