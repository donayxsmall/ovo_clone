class Auth {
  final String email;
  final String? password;
  Auth({
    required this.email,
    this.password,
  });

  factory Auth.init() => Auth(email: '', password: '');

  Map<String, dynamic> toMap() {
    return {
      'email': email,
      'password': password,
    };
  }

  @override
  String toString() => 'Auth(email: $email, password: $password)';

  Auth copyWith({
    String? email,
    String? password,
  }) {
    return Auth(
      email: email ?? this.email,
      password: password ?? this.password,
    );
  }
}
