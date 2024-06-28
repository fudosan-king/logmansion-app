class Validators {
  static String? emailValidator(String? value) {
    if (value == null || value.isEmpty) {
        return 'メールアドレスをご入力ください。';
    }
    final emailRegExp = RegExp(r'^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$');
    if (!emailRegExp.hasMatch(value)) {
      return '入力されたメールアドレスの形式が正しくありません';
    }
    return null;
  }

  static String? passwordValidator(String? value) {
    if (value == null || value.isEmpty) {
      return 'パスワードをご入力ください';
    }
    if (value.length < 8) {
      return '半角英字、数字、記号をそれぞれ１文字以上含む８文字以上';
    }
    if (!RegExp(r'[A-Z]').hasMatch(value)) {
      return '半角英字：「A-Z」';
    }
    if (!RegExp(r'[a-z]').hasMatch(value)) {
      return '半角英字：「a-z」';
    }
    if (!RegExp(r'[0-9]').hasMatch(value)) {
      return '半角数字：「0-9」';
    }
    if (!RegExp(r'[!._\-@]').hasMatch(value)) {
      return '半角記号：「!」、「.」、「_」、「-」、「@」';
    }
    return null;
  }
}