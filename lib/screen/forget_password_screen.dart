// ignore_for_file: camel_case_types, prefer_typing_uninitialized_variables

import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';
import 'package:ovo_clone/core.dart';

class ForgetPasswordScreen extends StatefulWidget {
  const ForgetPasswordScreen({Key? key}) : super(key: key);

  @override
  State<ForgetPasswordScreen> createState() => _ForgetPasswordScreenState();
}

class _ForgetPasswordScreenState extends State<ForgetPasswordScreen> {
  bool obsecure = true;

  final _formKey = GlobalKey<FormState>();
  String? email;

  doSendOtp() {
    final form = _formKey.currentState;
    if (form == null || !form.validate()) return;
    form.save();
    final auth = Auth(email: email!);

    context.goNamed('otp-forget-password', extra: auth);
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
              Navigator.pop(context);
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
                            Expanded(
                              child: Form(
                                key: _formKey,
                                child: XTextField(
                                  label: 'Enter your e-mail ID',
                                  validator: Validator.email,
                                  icon: Icons.email,
                                  onChanged: (value) {},
                                  onSaved: (value) {
                                    email = value;
                                  },
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
                                doSendOtp();
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
