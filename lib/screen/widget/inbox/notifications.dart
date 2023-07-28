// ignore_for_file: camel_case_types, prefer_typing_uninitialized_variables

import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
import 'package:ovo_clone/core.dart';

class Notifications extends StatefulWidget {
  const Notifications({Key? key}) : super(key: key);

  @override
  State<Notifications> createState() => _NotificationsState();
}

class _NotificationsState extends State<Notifications> {
  final List<NotificationModel> notifications = [
    NotificationModel(
        title: 'title 1',
        message:
            'Rp 1.000 telah di potong dari OVO Cash untuk biaya top up dari BANK BCA',
        date: DateTime(2023, 7, 26)),
    NotificationModel(
        title: 'title 2',
        message: 'Top up sebesar Rp 30.000 melalui BANK BCA, telah berhasil',
        date: DateTime(2023, 7, 26)),
    NotificationModel(
        title: 'title 3',
        message: 'Yah, kuota promo ini terbatas dan udah habis',
        date: DateTime(2023, 7, 27)),
    NotificationModel(
        title: 'title 4',
        message:
            'Rp 1.000 telah di potong dari OVO Cash untuk biaya top up dari BANK BCA',
        date: DateTime(2023, 7, 27)),
    NotificationModel(
        title: 'title 4.1',
        message: 'Top up sebesar Rp 310.000 melalui BANK BCA, telah berhasil',
        date: DateTime(2023, 7, 27)),
    NotificationModel(
        title: 'title 5',
        message:
            'Rp 1.000 telah di potong dari OVO Cash untuk biaya top up dari BANK BCA',
        date: DateTime(2023, 7, 28)),
  ];

  @override
  Widget build(BuildContext context) {
    return ListView.builder(
      itemCount: notifications.length,
      physics: const ScrollPhysics(),
      // separatorBuilder: (context, index) =>
      //     index == notifications.length - 1 ? Container() : const Divider(),
      itemBuilder: (BuildContext context, int index) {
        bool separated = index == 0 ||
            notifications[index].date != notifications[index - 1].date;
        if (index == 0 ||
            notifications[index].date != notifications[index - 1].date) {
          return Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Container(
                width: MediaQuery.of(context).size.width,
                padding: const EdgeInsets.all(5.0),
                color: const Color(0xffF4F4F4),
                child: Container(
                  margin: const EdgeInsets.only(
                    left: 20.0,
                  ),
                  child: Text(
                    _formatDate(notifications[index].date),
                    style: const TextStyle(
                      fontSize: 12.0,
                      color: Color(0xff909090),
                    ),
                  ),
                ),
              ),
              _buildNotificationItem(notifications[index], separated),
            ],
          );
        } else {
          return _buildNotificationItem(notifications[index], separated);
        }
      },
    );
  }

  String _formatDate(DateTime date) {
    String formattedDate = DateFormat('dd MMMM yyyy', 'id').format(date);
    return formattedDate;
    // return '${date.day} ${date.month} ${date.year}';
  }

  Widget _buildNotificationItem(
      NotificationModel notification, bool separated) {
    return Column(
      children: [
        separated ? Container() : const Divider(),
        Container(
          margin: const EdgeInsets.only(
            left: 20.0,
          ),
          child: ListTile(
            onTap: () {},
            title: Text(
              notification.message,
              style: const TextStyle(
                fontSize: 12.0,
                color: Colors.black,
                fontWeight: FontWeight.bold,
              ),
            ),
          ),
        ),
      ],
    );
  }
}
