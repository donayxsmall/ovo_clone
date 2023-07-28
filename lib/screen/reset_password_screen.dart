// ignore_for_file: camel_case_types, prefer_typing_uninitialized_variables

import 'package:flutter/material.dart';
import 'package:ovo_clone/core.dart';

class ResetPasswordScreen extends StatefulWidget {
  const ResetPasswordScreen({Key? key}) : super(key: key);

  @override
  State<ResetPasswordScreen> createState() => _ResetPasswordScreenState();
}

class _ResetPasswordScreenState extends State<ResetPasswordScreen> {
  String? password, confPassword;
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
              top: MediaQuery.of(context).size.height * 0.04,
            ),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Center(
                  child: Image.asset(
                    'assets/image/reset_password.png',
                    width: 369,
                    height: 280,
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
                      const Text(
                        "Reset Password",
                        style: TextStyle(
                          fontSize: 20.0,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                      const Text(
                        "Create new password for your account",
                        style: TextStyle(
                          fontSize: 12.0,
                          color: Color(0xff909090),
                          letterSpacing: 12 * 0.08,
                        ),
                      ),
                      const SizedBox(
                        height: 20.0,
                      ),
                      XPasswordField(
                        label: 'Enter new password',
                        icon: Icons.visibility,
                        validator: Validator.password,
                        onChanged: (value) {
                          password = value;
                        },
                      ),
                      const SizedBox(
                        height: 10.0,
                      ),
                      XPasswordField(
                        label: 'Enter confirm password',
                        icon: Icons.phone_android,
                        validator: (value) =>
                            Validator.confirmPassword(value, password),
                        onChanged: (value) {
                          confPassword = value;
                        },
                      ),
                      const SizedBox(
                        height: 20.0,
                      ),
                      Center(
                        child: SizedBox(
                          width: 249,
                          height: 43,
                          child: ElevatedButton(
                            style: ElevatedButton.styleFrom(
                              backgroundColor: primaryColor,
                            ),
                            onPressed: () {},
                            child: const Text("Confirm"),
                          ),
                        ),
                      ),
                    ],
                  ),
                )
              ],
            ),
          )
        ],
      ),
    );
  }
}
