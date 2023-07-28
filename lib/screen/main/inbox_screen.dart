// ignore_for_file: camel_case_types, prefer_typing_uninitialized_variables

import 'package:flutter/material.dart';
import 'package:ovo_clone/core.dart';

class InboxScreen extends StatefulWidget {
  const InboxScreen({Key? key}) : super(key: key);

  @override
  State<InboxScreen> createState() => _InboxScreenState();
}

class _InboxScreenState extends State<InboxScreen> {
  final List<Tab> tabs = [
    const Tab(
      text: "Notifications",
    ),
    const Tab(
      text: "Message",
    ),
  ];

  List messageList = [
    {
      "image": const AssetImage('assets/image/notification/message1.png'),
      "title": "Top up e-Money Bisa Dari Aplikasi OVO",
      "description": "Kini kamu bisa top up saldo e-Money di aplikasi OVO lho!",
      "expiredDate": "Berlaku sampai 30 Jun 2023",
    },
    {
      "image": const AssetImage('assets/image/notification/message2.png'),
      "title": "Top up e-Money Bisa Dari Aplikasi OVO",
      "description": "Kini kamu bisa top up saldo e-Money di aplikasi OVO lho!",
      "expiredDate": "Berlaku sampai 30 Jun 2023",
    }
  ];

  @override
  Widget build(BuildContext context) {
    return DefaultTabController(
      length: tabs.length,
      child: Scaffold(
        appBar: AppBar(
          backgroundColor: Colors.white,
          bottom: TabBar(
            labelColor: primaryColor,
            unselectedLabelColor: const Color(0xff909090),
            indicatorColor: primaryColor,
            tabs: tabs,
          ),
          title: const Text(
            'Notifications',
            style: TextStyle(
              fontSize: 15.0,
              color: Colors.black,
              fontWeight: FontWeight.bold,
            ),
          ),
        ),
        body: TabBarView(
          children: [
            const Notifications(),
            Container(
              padding: const EdgeInsets.only(
                bottom: 10.0,
              ),
              child: ListView.separated(
                itemCount: messageList.length,
                physics: const ScrollPhysics(),
                separatorBuilder: (context, index) => const Divider(),
                itemBuilder: (BuildContext context, int index) {
                  var item = messageList[index];
                  return ListMessage(
                    image: item['image'],
                    title: item['title'],
                    description: item['description'],
                    expiredDate: item['expiredDate'],
                  );
                },
              ),
            ),
          ],
        ),
      ),
    );
  }
}
