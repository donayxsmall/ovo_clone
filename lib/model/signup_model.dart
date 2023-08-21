import 'package:equatable/equatable.dart';

class Signup extends Equatable {
  final String email;
  final String phone;
  final String password;
  const Signup({
    required this.email,
    required this.phone,
    required this.password,
  });

  factory Signup.init() => const Signup(email: '', phone: '', password: '');

  @override
  String toString() =>
      'Signup(email: $email, phone: $phone, password: $password)';

  Signup copyWith({
    String? email,
    String? phone,
    String? password,
  }) {
    return Signup(
      email: email ?? this.email,
      phone: phone ?? this.phone,
      password: password ?? this.password,
    );
  }

  @override
  List<Object> get props => [email, phone, password];

  Map<String, dynamic> toMap() {
    return {
      'email': email,
      'phone': phone,
      'password': password,
    };
  }
}
