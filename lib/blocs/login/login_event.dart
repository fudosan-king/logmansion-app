import 'package:equatable/equatable.dart';

sealed class LoginEvent extends Equatable {
  const LoginEvent();

  @override
  List<Object> get props => [];
}

final class LoginUsernameChanged extends LoginEvent {
  const LoginUsernameChanged(this.username);

  final String username;

  @override
  List<Object> get props => [username];
}

final class LoginPasswordChanged extends LoginEvent {
  const LoginPasswordChanged(this.password);

  final String password;

  @override
  List<Object> get props => [password];
}

final class LoginSubmitted extends LoginEvent {
  const LoginSubmitted();
}

final class UpdateUser extends LoginEvent {
  const UpdateUser(this.email, this.password);
  final String email;
  final String password;
}

final class ForgotPassword extends LoginEvent {
  const ForgotPassword(this.email);
  final String email;
}

final class ForgotClientID extends LoginEvent {
  const ForgotClientID(this.email);
  final String email;
}