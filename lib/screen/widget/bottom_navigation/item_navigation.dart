// ignore_for_file: camel_case_types, prefer_typing_uninitialized_variables

import 'package:flutter/material.dart';

class ItemNavigation extends StatefulWidget {
  const ItemNavigation({
    Key? key,
    required this.icon,
    required this.label,
    this.onTap,
  }) : super(key: key);

  final Widget icon;
  final String label;
  final Function()? onTap;

  @override
  State<ItemNavigation> createState() => _ItemNavigationState();
}

class _ItemNavigationState extends State<ItemNavigation> {
  @override
  Widget build(BuildContext context) {
    return Container();
  }
}
