// ignore_for_file: camel_case_types, prefer_typing_uninitialized_variables

import 'package:flutter/gestures.dart';
import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:ovo_clone/screen/forget_password_screen.dart';

class PasswordScreen extends StatefulWidget {
  const PasswordScreen({Key? key}) : super(key: key);

  @override
  State<PasswordScreen> createState() => _PasswordScreenState();
}

class _PasswordScreenState extends State<PasswordScreen> {
  TextEditingController passwordController = TextEditingController();
  bool obsecure = true;

  @override
  void dispose() {
    passwordController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        body: Stack(
      children: [
        Container(
          decoration: const BoxDecoration(
            image: DecorationImage(
                image: AssetImage(
                  'assets/image/BACKGROUND.png',
                ),
                fit: BoxFit.cover),
          ),
        ),
        SizedBox(
          height: MediaQuery.of(context).size.height * 0.6,
          child: Center(
            child: SvgPicture.asset(
              'assets/image/logo_ovo.svg',
            ),
          ),
        ),
        Positioned(
          top: MediaQuery.of(context).size.height * 0.45,
          child: SizedBox(
            width: MediaQuery.of(context).size.width,
            child: Container(
              margin: const EdgeInsets.all(20.0),
              child: Column(
                children: [
                  Row(
                    crossAxisAlignment: CrossAxisAlignment.end,
                    children: [
                      Image.asset(
                        'assets/image/padlock.png',
                        width: 20,
                        height: 20,
                      ),
                      const SizedBox(
                        width: 10.0,
                      ),
                      Expanded(
                        child: TextFormField(
                          style: const TextStyle(
                            color: Colors.white,
                          ),
                          controller: passwordController,
                          obscureText: obsecure,
                          decoration: InputDecoration(
                            labelText: 'Enter your password',
                            labelStyle: const TextStyle(
                                color: Colors.white, height: 0.2),
                            enabledBorder: const UnderlineInputBorder(
                              borderSide: BorderSide(color: Colors.white),
                            ),
                            focusedBorder: const UnderlineInputBorder(
                              borderSide: BorderSide(color: Colors.white),
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
                        ),
                      ),
                    ],
                  ),
                  const SizedBox(
                    height: 20.0,
                  ),
                  SizedBox(
                    width: MediaQuery.of(context).size.width,
                    height: 45,
                    child: ElevatedButton(
                      style: ElevatedButton.styleFrom(
                          backgroundColor: const Color(0xff00B0B7),
                          shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(30))),
                      onPressed: () {},
                      child: const Text(
                        "LOGIN",
                        style: TextStyle(
                          fontSize: 12.0,
                        ),
                      ),
                    ),
                  ),
                  const SizedBox(
                    height: 10.0,
                  ),
                  RichText(
                    text: TextSpan(
                      text: 'Forgot your ',
                      style: const TextStyle(
                        fontSize: 12.0,
                      ),
                      children: [
                        TextSpan(
                          text: 'password ?',
                          style: const TextStyle(
                            color: Color(0xff00B0B7),
                            fontSize: 12.0,
                          ),
                          recognizer: TapGestureRecognizer()
                            ..onTap = () {
                              Navigator.push(
                                context,
                                MaterialPageRoute(
                                    builder: (context) =>
                                        const ForgetPasswordScreen()),
                              );
                            },
                        )
                      ],
                    ),
                  )
                ],
              ),
            ),
          ),
        ),
      ],
    ));
  }
}
