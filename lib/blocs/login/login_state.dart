
import 'package:equatable/equatable.dart';
import 'package:formz/formz.dart';

import '../../screens/login/component/password.dart';
import '../../screens/login/component/username.dart';

final class LoginState extends Equatable {
  const LoginState({
    this.status = FormzSubmissionStatus.initial,
    this.clientID = const Username.pure(),
    this.password = const Password.pure(),
    this.isValid = false,
    this.message,
  });

  final FormzSubmissionStatus status;
  final Username clientID;
  final Password password;
  final bool isValid;
  final String? message;

  LoginState copyWith({
    FormzSubmissionStatus? status,
    Username? clientID,
    Password? password,
    bool? isValid,
    String? message,
  }) {
    return LoginState(
      status: status ?? this.status,
      clientID: clientID ?? this.clientID,
      password: password ?? this.password,
      isValid: isValid ?? this.isValid,
      message: message,
    );
  }

  @override
  List<Object> get props => [status, clientID, password];
  // List<Object> get props => [status];
}