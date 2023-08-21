import 'package:flutter/material.dart';
import 'package:flutter/services.dart';

class OtpTextField extends StatefulWidget {
  const OtpTextField({
    Key? key,
    required this.numberOfFields,
    required this.onChanged,
  }) : super(key: key);

  final int numberOfFields;
  final Function(List<String>) onChanged;

  @override
  State<OtpTextField> createState() => _OtpTextFieldState();
}

class _OtpTextFieldState extends State<OtpTextField> {
  late final List<FocusNode> focusNodes;
  late final List<TextEditingController> textControllers;
  late final List<String> otpValues;
  final _numberFormatter = FilteringTextInputFormatter.digitsOnly;

  @override
  void initState() {
    super.initState();
    focusNodes = List.generate(widget.numberOfFields, (index) => FocusNode());
    textControllers = List.generate(
        widget.numberOfFields, (index) => TextEditingController());
    otpValues = [];
  }

  @override
  void dispose() {
    for (var controller in textControllers) {
      controller.dispose();
    }
    super.dispose();
  }

  void _moveToNextField(String value, int currentIndex) {
    if (value.isNotEmpty && currentIndex < widget.numberOfFields - 1) {
      setState(() {
        textControllers[currentIndex].text = value;
      });
      FocusScope.of(context).requestFocus(focusNodes[currentIndex + 1]);
    }

    if (value.isEmpty && currentIndex != 0) {
      setState(() {
        textControllers[currentIndex].text = value;
      });
      FocusScope.of(context).requestFocus(focusNodes[currentIndex - 1]);
    }
  }

  void _captureValues() {
    otpValues.clear();
    for (var controller in textControllers) {
      if (controller.text.isNotEmpty) {
        otpValues.add(controller.text);
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Row(
      crossAxisAlignment: CrossAxisAlignment.center,
      mainAxisAlignment: MainAxisAlignment.center,
      children: List.generate(
        widget.numberOfFields,
        (index) {
          return Container(
            width: 45,
            height: 45,
            padding: const EdgeInsets.all(8),
            margin: const EdgeInsets.only(
              left: 10.0,
            ),
            decoration: BoxDecoration(
              borderRadius: BorderRadius.circular(10),
              border: Border.all(color: const Color(0xff909090), width: 1),
            ),
            child: TextFormField(
              controller: textControllers[index],
              inputFormatters: [_numberFormatter],
              focusNode: focusNodes[index],
              style: const TextStyle(fontSize: 24.0, color: Color(0xff909090)),
              textAlign: TextAlign.center,
              maxLength: 1,
              keyboardType: TextInputType.number,
              decoration: const InputDecoration(
                border: InputBorder.none,
                counterText: '',
              ),
              onChanged: (value) {
                _moveToNextField(value, index);
                _captureValues();
                widget.onChanged(otpValues);
              },
              // onEditingComplete: () {
              //   _captureValues();
              // },
            ),
          );
        },
      ),
    );
  }
}
