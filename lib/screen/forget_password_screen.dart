// ignore_for_file: camel_case_types, prefer_typing_uninitialized_variables

import 'package:flutter/material.dart';
import 'package:ovo_clone/core.dart';

class ForgetPasswordScreen extends StatefulWidget {
  const ForgetPasswordScreen({Key? key}) : super(key: key);

  @override
  State<ForgetPasswordScreen> createState() => _ForgetPasswordScreenState();
}

class _ForgetPasswordScreenState extends State<ForgetPasswordScreen> {
  TextEditingController passwordController = TextEditingController();
  bool obsecure = true;
  final FocusNode _focusNode = FocusNode();

  @override
  void dispose() {
    passwordController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        extendBodyBehindAppBar: true,
        appBar: AppBar(
          backgroundColor: Colors.transparent,
          elevation: 0,
          leading: InkWell(
            onTap: () {
              Navigator.of(context);
            },
            child: Image.asset('assets/image/arrow_back.png'),
          ),
        ),
        body: Stack(
          children: [
            Container(
              decoration: const BoxDecoration(
                image: DecorationImage(
                    image: AssetImage(
                      'assets/image/background_forget_password.png',
                    ),
                    fit: BoxFit.cover),
              ),
            ),
            Positioned(
              bottom: 0,
              child: Container(
                height: MediaQuery.of(context).size.height * 0.6,
                width: MediaQuery.of(context).size.width,
                decoration: const BoxDecoration(
                  image: DecorationImage(
                      image: AssetImage(
                        'assets/image/gradient_body.png',
                      ),
                      fit: BoxFit.cover),
                ),
              ),
            ),
            Container(
              margin: EdgeInsets.only(
                top: MediaQuery.of(context).size.height * 0.06,
              ),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Center(
                    child: Image.asset(
                      'assets/image/forget_password.png',
                      height: 300,
                    ),
                  ),
                  const SizedBox(
                    height: 20.0,
                  ),
                  Container(
                    margin: const EdgeInsets.only(left: 30, right: 30),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          "Forget Password",
                          style: TextStyle(
                              fontSize: 20.0,
                              fontWeight: FontWeight.bold,
                              color: primaryColor),
                        ),
                        const Text(
                          "Enter your e-mail to Change your password",
                          style: TextStyle(
                            fontSize: 12.0,
                            color: Color(0xff909090),
                            letterSpacing: 12 * 0.08,
                          ),
                        ),
                        const SizedBox(
                          height: 20.0,
                        ),
                        Row(
                          crossAxisAlignment: CrossAxisAlignment.end,
                          children: [
                            Icon(
                              Icons.email,
                              color: primaryColor,
                            ),
                            const SizedBox(
                              width: 10.0,
                            ),
                            Expanded(
                              child: TextFormField(
                                focusNode: _focusNode,
                                style: const TextStyle(
                                  color: Colors.black,
                                ),
                                decoration: InputDecoration(
                                  labelText: 'Enter your e-mail ID',
                                  labelStyle: TextStyle(
                                      height: 0.07,
                                      color: Colors.black,
                                      fontWeight: _focusNode.hasFocus
                                          ? FontWeight.bold
                                          : FontWeight.normal),
                                  focusedBorder: UnderlineInputBorder(
                                    borderSide: BorderSide(color: primaryColor),
                                  ),
                                ),
                              ),
                            )
                          ],
                        ),
                        const SizedBox(
                          height: 25.0,
                        ),
                        Center(
                          child: SizedBox(
                            width: 258,
                            height: 43,
                            child: ElevatedButton(
                              style: ElevatedButton.styleFrom(
                                  backgroundColor: primaryColor,
                                  shape: RoundedRectangleBorder(
                                      borderRadius: BorderRadius.circular(10))),
                              onPressed: () {
                                Navigator.push(
                                  context,
                                  MaterialPageRoute(
                                      builder: (context) =>
                                          const OtpForgetPasswordScreen()),
                                );
                              },
                              child: const Text(
                                "SEND OTP",
                                style: TextStyle(
                                  fontSize: 12.0,
                                  color: Color(0xffFFFFFF),
                                ),
                              ),
                            ),
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            )
          ],
        ));
  }
}
