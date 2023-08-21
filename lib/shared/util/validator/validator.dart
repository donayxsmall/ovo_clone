class Validator {
  static String? required(dynamic value) {
    if (value is String || value == null) {
      if (value.toString() == "null") return "This field is required";
      if (value!.isEmpty) return "This field is required";
    }

    if (value is int) {
      if (value == -1) return "This field is required";
    }

    if (value is List) {
      if (value.isEmpty) return "This field is required";
    }
    return null;
  }

  static String? email(String? value) {
    if (value!.isEmpty) return "This field is required";

    final bool isValidEmail = RegExp(
            "^[a-zA-Z0-9.a-zA-Z0-9.!#\$%&'*+-/=?^_`{|}~]+@[a-zA-Z0-9]+.[a-zA-Z]+")
        .hasMatch(value);

    if (!isValidEmail) {
      return "This field is not in a valid email format";
    }
    return null;
  }

  static String? password(String? value) {
    if (value!.isEmpty) return "This field is required";

    if (value.length <= 6) {
      return "Password has been least 6 character";
    }
    return null;
  }

  static String? confirmPassword(String? confPassword, String? password) {
    if (confPassword!.isEmpty) return "This field is required";

    if (confPassword.length <= 6) {
      return "Password has been least 6 character";
    }

    if (confPassword != password) {
      return "Confirm Password not match";
    }

    return null;
  }
}
