// ignore_for_file: camel_case_types, prefer_typing_uninitialized_variables

import 'package:flutter/material.dart';
import 'package:ovo_clone/core.dart';

class SecureCodeScreen extends StatefulWidget {
  const SecureCodeScreen({Key? key}) : super(key: key);

  @override
  State<SecureCodeScreen> createState() => _SecureCodeScreenState();
}

class _SecureCodeScreenState extends State<SecureCodeScreen> {
  late final List<TextEditingController> textEditingController;

  List<int> orderTextInput = [];
  int currentInput = 0;
  int numberDigit = 6;
  bool completed = false;

  @override
  void initState() {
    super.initState();
    textEditingController =
        List.generate(numberDigit, (index) => TextEditingController());
  }

  @override
  void dispose() {
    for (var controller in textEditingController) {
      controller.dispose();
    }
    super.dispose();
  }

  String securityCode = '';
  void updateSecurityCode(String digit, int currentText) {
    setState(() {
      if (currentText < numberDigit) {
        securityCode += digit;
        textEditingController[currentText].text = digit;
        toogleInput(currentText);
        currentInput++;
      }
    });

    if (currentText >= numberDigit - 1) {
      snackbarSuccess(message: 'Success Input , security code : $securityCode');
    }
  }

  void toogleInput(int number) {
    setState(() {
      if (orderTextInput.contains(number)) {
        orderTextInput.remove(number);
      } else {
        orderTextInput.add(number);
      }
    });
  }

  // void submit() async {
  //   await snackbarSuccess(
  //       message: 'Success Input , security code : $securityCode');
  // }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(
        width: MediaQuery.of(context).size.width,
        decoration: const BoxDecoration(
          image: DecorationImage(
              image: AssetImage(
                'assets/image/BACKGROUND.png',
              ),
              fit: BoxFit.cover),
        ),
        child: Column(
          children: [
            const SizedBox(
              height: 40.0,
            ),
            Center(
              child: Container(
                margin: const EdgeInsets.only(left: 30.0, right: 30.0),
                child: Column(
                  children: [
                    const Text(
                      "Enter Your Security Code",
                      style: TextStyle(
                          fontSize: 18.0,
                          fontWeight: FontWeight.bold,
                          color: Colors.white,
                          letterSpacing: 18 * 0.18),
                    ),
                    const SizedBox(
                      height: 30.0,
                    ),
                    Row(
                      mainAxisAlignment: MainAxisAlignment.spaceAround,
                      crossAxisAlignment: CrossAxisAlignment.center,
                      children: List.generate(
                        numberDigit,
                        (index) {
                          return Container(
                            width: 10,
                            height: 10,
                            decoration: BoxDecoration(
                              shape: BoxShape.circle,
                              border: Border.all(color: Colors.white, width: 1),
                              color: orderTextInput.contains(index)
                                  ? Colors.white
                                  : null,
                            ),
                            child: TextFormField(
                              controller: textEditingController[index],
                              textAlign: TextAlign.center,
                              style: const TextStyle(
                                color: Colors.transparent,
                              ),
                              showCursor: false,
                              enabled: false,
                              maxLength: 1,
                              keyboardType: TextInputType.number,
                              decoration: const InputDecoration(
                                border: InputBorder.none,
                                counterText: '',
                              ),
                            ),
                          );
                        },
                      ),
                    ),
                    const SizedBox(
                      height: 30.0,
                    ),
                    const Text(
                      "Forget Security Code",
                      style: TextStyle(
                        fontSize: 16.0,
                        fontWeight: FontWeight.bold,
                        color: Color(0xff00B0B7),
                      ),
                    ),
                    const SizedBox(
                      height: 20.0,
                    ),
                    SingleChildScrollView(
                      child: GridView.builder(
                        padding: EdgeInsets.zero,
                        gridDelegate:
                            const SliverGridDelegateWithFixedCrossAxisCount(
                          childAspectRatio: 1.0,
                          crossAxisCount: 3,
                          mainAxisSpacing: 15,
                          crossAxisSpacing: 6,
                        ),
                        itemCount: 12,
                        shrinkWrap: true,
                        physics: const NeverScrollableScrollPhysics(),
                        itemBuilder: (BuildContext context, int index) {
                          int digit = index == 10 ? 0 : index + 1;

                          if (index == 9 || index == 11) {
                            return Container();
                          }
                          if (index == 10) {
                            return SecurityCodeDigitButton(
                              digit: '0',
                              onPressed: () {
                                updateSecurityCode(
                                    digit.toString(), currentInput);

                                print(currentInput);

                                print("sdsd : $orderTextInput");
                              },
                            );
                          }
                          return SecurityCodeDigitButton(
                            digit: '${index + 1}',
                            onPressed: () {
                              updateSecurityCode(
                                  digit.toString(), currentInput);
                              print(currentInput);

                              print("sdsd : $orderTextInput");
                            },
                          );
                        },
                      ),
                    ),
                  ],
                ),
              ),
            ),
            const SizedBox(
              height: 30.0,
            ),
            // ElevatedButton(
            //   style: ElevatedButton.styleFrom(
            //     backgroundColor: Colors.blueGrey,
            //   ),
            //   onPressed: () {
            //     print(securityCode);
            //   },
            //   child: const Text("Save"),
            // ),
          ],
        ),
      ),
    );
  }
}

class SecurityCodeDigitButton extends StatelessWidget {
  final String digit;
  final VoidCallback onPressed;
  final bool isCentered;

  const SecurityCodeDigitButton({
    Key? key,
    required this.digit,
    required this.onPressed,
    this.isCentered = false,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return FractionallySizedBox(
      widthFactor: 0.3,
      child: Center(
        child: InkWell(
          onTap: onPressed,
          child: Text(
            digit,
            style: const TextStyle(
              fontSize: 32.0,
              fontWeight: FontWeight.bold,
              color: Colors.white,
            ),
          ),
        ),
      ),
    );
  }
}
