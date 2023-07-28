// ignore_for_file: camel_case_types, prefer_typing_uninitialized_variables

import 'package:flutter/material.dart';
import 'package:ovo_clone/core.dart';

class FinanceScreen extends StatefulWidget {
  const FinanceScreen({Key? key}) : super(key: key);

  @override
  State<FinanceScreen> createState() => _FinanceScreenState();
}

class _FinanceScreenState extends State<FinanceScreen> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Stack(
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
                  "Finance",
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
                  child: Column(
                    children: [
                      const SizedBox(
                        height: 40.0,
                      ),
                      const Divider(),
                      Container(
                        padding: const EdgeInsets.all(20.0),
                        child: const Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(
                              "Saatnya investasi dengan yang pasti",
                              style: TextStyle(
                                fontSize: 10.0,
                                fontWeight: FontWeight.bold,
                                color: Colors.black,
                              ),
                            ),
                            SizedBox(
                              height: 5.0,
                            ),
                            Text(
                              "Beli produk investasi dengan mudah dan aman pake OVO Cash!",
                              style: TextStyle(
                                fontSize: 10.0,
                                color: Color(0xff909090),
                              ),
                            ),
                          ],
                        ),
                      ),
                      const Divider(),
                      Container(
                        padding: const EdgeInsets.all(20.0),
                        child: Row(
                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: [
                            const Text(
                              "Powered by Xsmall",
                              style: TextStyle(
                                fontSize: 14.0,
                                fontWeight: FontWeight.bold,
                                color: Color(0xff909090),
                              ),
                            ),
                            SizedBox(
                              height: 21,
                              child: ElevatedButton(
                                style: ElevatedButton.styleFrom(
                                    backgroundColor: primaryColor,
                                    shape: RoundedRectangleBorder(
                                      borderRadius: BorderRadius.circular(20),
                                    )),
                                onPressed: () {},
                                child: const Text(
                                  "Mulai",
                                  style: TextStyle(
                                    color: Colors.white,
                                    fontSize: 10.0,
                                  ),
                                ),
                              ),
                            ),
                          ],
                        ),
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
