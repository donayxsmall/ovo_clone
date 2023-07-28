// ignore_for_file: camel_case_types, prefer_typing_uninitialized_variables

import 'package:flutter/material.dart';

import 'package:ovo_clone/core.dart';

class XPasswordField extends StatefulWidget {
  const XPasswordField({
    Key? key,
    required this.label,
    required this.icon,
    this.validator,
    required this.onChanged,
  }) : super(key: key);

  final String label;
  final IconData icon;
  final String? Function(String?)? validator;
  final Function(String) onChanged;

  @override
  State<XPasswordField> createState() => _XPasswordFieldState();
}

class _XPasswordFieldState extends State<XPasswordField> {
  TextEditingController textEditingController = TextEditingController();
  bool obsecure = true;

  @override
  void dispose() {
    textEditingController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Row(
      crossAxisAlignment: CrossAxisAlignment.end,
      children: [
        Icon(
          widget.icon,
          color: primaryColor,
        ),
        const SizedBox(
          width: 10.0,
        ),
        Expanded(
          child: TextFormField(
            controller: textEditingController,
            autovalidateMode: AutovalidateMode.onUserInteraction,
            validator: widget.validator,
            obscureText: obsecure,
            style: const TextStyle(
              color: Colors.black,
            ),
            decoration: InputDecoration(
              labelText: widget.label,
              labelStyle: const TextStyle(
                height: 0.07,
                color: Colors.black,
              ),
              focusedBorder: UnderlineInputBorder(
                borderSide: BorderSide(color: primaryColor),
              ),
              suffixIcon: IconButton(
                onPressed: () {
                  obsecure = !obsecure;
                  setState(() {});
                },
                icon: obsecure
                    ? const Icon(Icons.visibility_off)
                    : const Icon(Icons.visibility),
              ),
            ),
            onChanged: (value) {
              widget.onChanged(value);
            },
          ),
        )
      ],
    );
  }
}
