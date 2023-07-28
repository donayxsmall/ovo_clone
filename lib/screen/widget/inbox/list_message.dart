// ignore_for_file: camel_case_types, prefer_typing_uninitialized_variables

import 'package:flutter/material.dart';

class ListMessage extends StatefulWidget {
  const ListMessage({
    Key? key,
    required this.image,
    required this.title,
    required this.description,
    required this.expiredDate,
  }) : super(key: key);

  final ImageProvider image;
  final String title;
  final String description;
  final String expiredDate;

  @override
  State<ListMessage> createState() => _ListMessageState();
}

class _ListMessageState extends State<ListMessage> {
  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 20),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Container(
            height: 160.0,
            decoration: const BoxDecoration(
              image: DecorationImage(
                image: AssetImage('assets/image/notification/message1.png'),
                fit: BoxFit.fill,
              ),
              borderRadius: BorderRadius.all(
                Radius.circular(
                  16.0,
                ),
              ),
            ),
          ),
          const SizedBox(
            height: 5.0,
          ),
          const Text(
            "Top up e-Money Bisa Dari Aplikasi OVO",
            textAlign: TextAlign.justify,
            style: TextStyle(
              fontSize: 18.0,
              fontWeight: FontWeight.bold,
              color: Colors.black,
            ),
          ),
          const SizedBox(
            height: 10.0,
          ),
          const Text(
            "Kini kamu bisa top up saldo e-Money di aplikasi OVO lho!",
            textAlign: TextAlign.justify,
            style: TextStyle(
              fontSize: 14.0,
              color: Colors.black,
            ),
          ),
          const SizedBox(
            height: 10.0,
          ),
          const Text(
            "Berlaku sampai 30 Jun 2023",
            style: TextStyle(
              fontSize: 12.0,
              color: Colors.grey,
            ),
          ),
        ],
      ),
    );
  }
}
