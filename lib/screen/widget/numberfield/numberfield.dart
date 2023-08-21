import 'package:flutter/material.dart';
import 'package:flutter/services.dart';

import 'package:ovo_clone/core.dart';

class XNumberField extends StatefulWidget {
  const XNumberField({
    Key? key,
    required this.label,
    required this.icon,
    this.validator,
    required this.onChanged,
    this.onSaved,
  }) : super(key: key);

  final String label;
  final IconData icon;
  final String? Function(String?)? validator;
  final Function(String) onChanged;
  final Function(String?)? onSaved;

  @override
  State<XNumberField> createState() => _XNumberFieldState();
}

class _XNumberFieldState extends State<XNumberField> {
  TextEditingController textEditingController = TextEditingController();
  final _numberFormatter = FilteringTextInputFormatter.digitsOnly;

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
            autovalidateMode: AutovalidateMode.onUserInteraction,
            controller: textEditingController,
            inputFormatters: [
              _numberFormatter
            ], // Menggunakan TextInputFormatter
            keyboardType: TextInputType.number,
            validator: widget.validator,
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
            ),
            onChanged: (value) {
              widget.onChanged(value);
            },
            onSaved: (value) {
              widget.onSaved!(value);
            },
          ),
        )
      ],
    );
  }
}
