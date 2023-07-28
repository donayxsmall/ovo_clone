class NotificationModel {
  NotificationModel({
    required this.title,
    required this.message,
    required this.date,
  });

  final DateTime date;
  final String message;
  final String title;
}
